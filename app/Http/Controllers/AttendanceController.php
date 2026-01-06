<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Location; 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $pegawaiId = Auth::id();
        $search = $request->input('search');
        $query = Attendance::where('pegawai_id', $pegawaiId)
                           ->with('lokasi');
        if ($search) {
            $translationMap = [
                'hadir' => 'H', 'terlambat' => 'T', 'sakit' => 'S', 'izin' => 'I',
                'alfa' => 'A', 'dinas luar' => 'DL', 'cuti' => 'CT',
                'disetujui' => 'Approved', 'ditunda' => 'Pending', 'ditolak' => 'Rejected',
            ];
            $lowerSearch = strtolower($search);
            $translatedSearch = $translationMap[$lowerSearch] ?? $search;
            $query->where(function($q) use ($search, $translatedSearch, $lowerSearch) {
                $q->where('keterangan', 'like', '%' . $search . '%')
                  ->orWhere('status_kehadiran', 'like', '%' . $translatedSearch . '%')
                  ->orWhere('status_persetujuan', 'like', '%' . $translatedSearch . '%');
                
                if ($lowerSearch == 'alfa') {
                    $q->orWhereIn('status_persetujuan', ['Pending', 'Rejected']);
                }
            });
        }              

        $riwayatAbsensi = $query->latest('tanggal') 
                               ->paginate(10) 
                               ->withQueryString(); 

        return view('pegawai.absensi.index', [
            'riwayatAbsensi' => $riwayatAbsensi,
            'search' => $search ?? '',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $zonaWaktu = 'Asia/Makassar';
        $today = Carbon::today($zonaWaktu);
        $now = Carbon::now($zonaWaktu);
        $userLat = $request->latitude;
        $userLon = $request->longitude;

         $jabatanBebasGps = [
                'Kepala Puskesmas', 
                'Koordinator Kepegawaian', 
                'Bendahara'
            ];
        $isPengecualian = in_array($user->jabatan, $jabatanBebasGps);

        $locations = Location::all();
        $validLocationId = null;
        $isWithinRadius = false;
        $detectedLocationName = '';

        foreach ($locations as $location) {
                $distance = $this->calculateDistance(
                    $userLat, 
                    $userLon, 
                    $location->latitude, 
                    $location->longitude
                );

                if ($distance <= $location->radius_meter) {
                    $isWithinRadius = true;
                    $validLocationId = $location->id;
                    $detectedLocationName = $location->nama_lokasi;
                    break;
                }
            }
        
        if (!$isWithinRadius && !$isPengecualian) {
                return back()->with('modal_error', 'Anda berada di luar lokasi absen.');
            }

        $attendanceToday = Attendance::where('pegawai_id', $user->id)
                                     ->whereDate('tanggal', $today)
                                     ->whereIn('status_persetujuan', ['Approved', 'Pending'])
                                     ->first();

        if (!$attendanceToday) {
            Attendance::where('pegawai_id', $user->id)
                ->whereDate('tanggal', $today)
                ->where('status_persetujuan', 'Rejected')
                ->delete();

            $jamBatasStr = '08:00:59'; 
            if (stripos($detectedLocationName, 'Toronipa') !== false || stripos($detectedLocationName, 'Tapulaga') !== false) {
                $jamBatasStr = '07:35:59';
            }

            $status = 'H';

            if ($user->status_kepegawaian !== 'PHL') {
                $batasTerlambat = Carbon::parse($today->toDateString() . ' ' . $jamBatasStr, $zonaWaktu);
                
                if ($now->isAfter($batasTerlambat)) {
                    $status = 'T';
                }
            }


            Attendance::create([
                'pegawai_id' => $user->id,
                'lokasi_id' => $validLocationId,
                'tanggal' => $today,
                'jam_masuk' => $now,
                'jam_pulang' => null,
                'status_kehadiran' => $status,
                'status_persetujuan' => 'Approved',
            ]);

            $pesan = ($status == 'T')? 'Absen Masuk (Terlambat) berhasil dicatat.' : 'Absen Masuk berhasil dicatat.';
            $notif = [
                'title'   => 'Absen Berhasil',
                'message' => $pesan
            ];
            return back()->with('success', $notif);

        } else {
            if (in_array($attendanceToday->status_kehadiran, ['S', 'I','CT'])) {
                $notif = [
                    'title'   => 'Terjadi Kesalahan',
                    'message' => 'Tidak bisa absen. Anda sudah tercatat ' . $attendanceToday->status_kehadiran . ' hari ini.'
                ];
                return back()->with('error', $notif);
            }

            if ($attendanceToday->jam_pulang) {
                $notif = [
                    'title'   => 'Terjadi Kesalahan',
                    'message' => 'Anda sudah melakukan Absen Pulang hari ini.'
                ];
                return back()->with('error', $notif);
            }

            $attendanceToday->update([
                'jam_pulang' => $now
            ]);

            $notif = [
                'title'   => 'Absen Berhasil',
                'message' => 'Absen pulang Anda telah berhasil dicatat pada jam ' . $now->format('H:i')
            ];
            return back()->with('success', $notif);
        }
    }

    
    private function calculateDistance($lat1, $lon1, $lat2, $lon2) 
    {
        $earthRadius = 6371000; 
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo   = deg2rad($lat2);
        $lonTo   = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = pow(sin($latDelta / 2), 2) +
             cos($latFrom) * cos($latTo) * 
             pow(sin($lonDelta / 2), 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}