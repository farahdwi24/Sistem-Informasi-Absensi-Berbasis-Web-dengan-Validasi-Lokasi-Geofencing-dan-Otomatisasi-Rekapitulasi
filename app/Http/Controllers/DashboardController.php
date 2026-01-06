<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        if ($user->role->nama_peran === 'Admin') {
            $startDate = $request->input('start_date', null);
            $endDate = $request->input('end_date', null); 
            $search = $request->input('search');
            $statusPegawai = $request->input('status_pegawai');
            $statusKehadiran = $request->input('status_kehadiran');
            $sortBy = $request->input('sort_by', 'tanggal');
            $sortOrder = $request->input('sort_order', 'desc');

            if (!in_array($sortBy, ['tanggal', 'nama_lengkap', 'status_kehadiran'])) {
                $sortBy = 'tanggal';
            }

            $query = Attendance::with('pegawai', 'lokasi') 
                        ->join('users', 'attendances.pegawai_id', '=', 'users.id')
                        ->select('attendances.*');

            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            }

            if ($search) {
                $translationMap = [
                    'hadir' => 'H',
                    'terlambat' => 'T',
                    'sakit' => 'S',
                    'izin' => 'I',
                    'alfa' => 'A',
                    'cuti' => 'CT',
                    'disetujui' => 'Approved',
                    'ditunda' => 'Pending',
                    'ditolak' => 'Rejected',
                ];
                $lowerSearch = strtolower($search);
                $translatedSearch = $translationMap[$lowerSearch] ?? $search;
                $query->where(function($q) use ($search, $translatedSearch, $lowerSearch) {
                    $q->where('users.nama_lengkap', 'like', '%' . $search . '%')
                      ->orWhere('users.nip', 'like', '%' . $search . '%')
                      ->orWhere('users.jabatan', 'like', '%' . $search . '%')
                      ->orWhere('users.penempatan', 'like', '%' . $search . '%');
                    $q->orWhere('attendances.status_kehadiran', 'like', '%' . $translatedSearch . '%');
                    $q->orWhere('attendances.status_persetujuan', 'like', '%' . $translatedSearch . '%');
                    if ($lowerSearch == 'alfa') {
                        $q->orWhereIn('attendances.status_persetujuan', ['Pending', 'Rejected']);
                    }
                });
            }

            if ($statusPegawai) {
                $query->where('users.status_kepegawaian', $statusPegawai);
            }

            if ($statusKehadiran) {
                if ($statusKehadiran == 'A') {
                    $query->whereIn('status_persetujuan', ['Pending', 'Rejected']);
                } else {
                    $query->where('status_kehadiran', $statusKehadiran)
                          ->where('status_persetujuan', 'Approved');
                }
            }
            
            if ($sortBy == 'nama_lengkap') {
                $query->orderBy('users.nama_lengkap', $sortOrder);
            } else {
                $query->orderBy('attendances.' . $sortBy, $sortOrder);
            }
            
            $attendances = $query->paginate(15)->withQueryString();

            return view('admin.dashboard', [
                'attendances' => $attendances,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'search' => $search,
                'sortBy' => $sortBy,
                'sortOrder' => $sortOrder,
                'statusPegawai' => $statusPegawai,
                'statusKehadiran' => $statusKehadiran,
            ]);
        } else {
            $attendanceToday = Attendance::where('pegawai_id', $user->id)
                                         ->whereDate('tanggal', Carbon::today())
                                         ->whereIn('status_persetujuan', ['Approved', 'Pending'])
                                         ->first();

            $startOfMonth = Carbon::today()->startOfMonth();
            $endOfMonth = Carbon::today()->endOfMonth();
                                 
            $monthlyStats = Attendance::where('pegawai_id', $user->id)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->where('status_persetujuan', 'Approved')
            ->select('status_kehadiran', DB::raw('count(*) as total'))
            ->groupBy('status_kehadiran')
            ->get()
            ->pluck('total', 'status_kehadiran');                 
                                 
            $totalHadir = $monthlyStats->get('H', 0);
            $totalTerlambat = $monthlyStats->get('T', 0);
            $totalIzinSakit = $monthlyStats->get('I', 0) + $monthlyStats->get('S', 0);
                                         
            return view('pegawai.dashboard', [
                'attendanceToday' => $attendanceToday,
                'totalHadir' => $totalHadir,
                'totalTerlambat' => $totalTerlambat,
                'totalIzinSakit' => $totalIzinSakit,
            ]);               
                                         
        }
    }

    public function editAbsensi(Attendance $attendance): View
    {
        $locations = Location::all();
        
        return view('admin.absensi.edit', [
            'absensi' => $attendance,
            'locations' => $locations
        ]);
    }

    public function updateAbsensi(Request $request, Attendance $attendance): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
                Rule::unique('attendances')->where(function ($query) use ($attendance) {
                    return $query->where('pegawai_id', $attendance->pegawai_id);
                })
                ->ignore($attendance->id),
            ],
            'status_kehadiran' => 'required|in:H,T,S,I,A,CT',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after_or_equal:jam_masuk',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'tanggal.unique' => 'GAGAL MEMPERBARUI: Pegawai tersebut sudah memiliki data absensi lain pada tanggal yang dipilih.',
        ]);

        $attendance->update($validated);

        $notif = [
            'title'   => 'Data Tersimpan',
            'message' => 'Data absensi tanggal ' . $attendance->tanggal->format('d M Y') . ' berhasil diperbarui.'
        ];
        return redirect()->route('dashboard')->with('success', $notif);
    }

    public function destroyAbsensi(Attendance $attendance): RedirectResponse
    {
        $tanggalAbsen = $attendance->tanggal->format('d M Y');
        if ($attendance->file_lampiran) {
            Storage::disk('public')->delete($attendance->file_lampiran);
        }
        $attendance->delete();
        
        $notif = [
            'title'   => 'Data Berhasil Dihapus',
            'message' => 'Data absensi tanggal ' . $tanggalAbsen . ' telah berhasil dihapus.'
        ];
        return back()->with('success', $notif);
    }
}