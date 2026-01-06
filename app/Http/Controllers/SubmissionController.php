<?php

namespace App\Http\Controllers;

use App\Models\Attendance; 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Notifications\PengajuanBaru;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;


class SubmissionController extends Controller
{
    public function create(): View
    {
        return view('pegawai.submissions.create');
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'status_kehadiran' => 'required|in:S,I,H,T,CT',
            'tanggal' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $exists = Attendance::where('pegawai_id', Auth::id())
                                ->where('tanggal', $value)
                                ->whereIn('status_persetujuan', ['Approved', 'Pending'])
                                ->exists();
                    
                    if ($exists) {
                        $fail('ANDA SUDAH MEMILIKI DATA ABSENSI PADA TANGGAL INI.');
                    }
                }
            ],
            'keterangan' => 'required|string|min:5',
            
            'jam_masuk' => 'nullable|required_if:status_kehadiran,H|required_if:status_kehadiran,T|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after_or_equal:jam_masuk',
            'file_lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'tanggal.unique' => 'ANDA SUDAH MEMILIKI DATA ABSENSI PADA TANGGAL INI.',
            'status_kehadiran.required' => 'Jenis pengajuan wajib dipilih.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'keterangan.min' => 'Keterangan minimal 5 karakter',
            'jam_masuk.required_if' => 'Jam masuk wajib diisi jika jenis pengajuan adalah Hadir atau Terlambat.',
            'file_lampiran.max' => 'Ukuran file lampiran tidak boleh lebih dari 2MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('file_lampiran')) {
            $filePath = $request->file('file_lampiran')->store('lampiran_pengajuan', 'public');
        }

        Attendance::where('pegawai_id', Auth::id())
            ->where('tanggal', $request->tanggal)
            ->where('status_persetujuan', 'Rejected')
            ->delete();

        $newAttendance = Attendance::create([
            'pegawai_id' => Auth::id(),
            'lokasi_id' => null,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status_kehadiran' => $request->status_kehadiran,
            'status_persetujuan' => 'Pending',
            'keterangan' => $request->keterangan,
            'file_lampiran' => $filePath, 
        ]);
        $admins = User::where('role_id', 1)->get();
    
        Notification::send($admins, new PengajuanBaru($newAttendance));

        $notif = [
            'title'   => 'Pengajuan Terkirim',
            'message' => 'Pengajuan ' . $newAttendance->status_kehadiran .' Anda telah terkirim dan menunggu persetujuan.'
        ];
        return redirect()->route('pengajuan.create')->with('success', $notif);
    }
}