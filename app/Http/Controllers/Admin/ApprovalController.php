<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance; 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Notifications\PengajuanDiproses;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ApprovalController extends Controller
{
    public function index(): View
    {
        $pengajuanPending = Attendance::where('status_persetujuan', 'Pending')
                                      ->with('pegawai')
                                      ->latest('tanggal')
                                      ->paginate(10);
        
        return view('admin.approvals.index', [
            'pengajuanPending' => $pengajuanPending,
        ]);
    }

    public function approve(Attendance $attendance): RedirectResponse
    {
        $attendance->update([
            'status_persetujuan' => 'Approved'
        ]);
        $pegawai = $attendance->pegawai;
        $pegawai->notify(new PengajuanDiproses($attendance));

        $notif = [
            'title'   => 'Pengajuan Disetujui',
            'message' => 'Pengajuan dari ' . $pegawai->nama_lengkap . ' telah disetujui.'
        ];
        return back()->with('success', $notif);
    }

    public function reject(Attendance $attendance): RedirectResponse
    {
        $attendance->update([
            'status_persetujuan' => 'Rejected'
        ]);
        $pegawai = $attendance->pegawai;
        $pegawai->notify(new PengajuanDiproses($attendance));

        $notif = [
            'title'   => 'Pengajuan Ditolak',
            'message' => 'Pengajuan dari ' . $pegawai->nama_lengkap . ' telah ditolak.'
        ];
        return back()->with('success', $notif);
    }

    public function createPengajuan(): View
    {
        $pegawaiList = User::where('role_id', '!=', 1)->orderBy('nama_lengkap')->get();
        
        return view('admin.approvals.create', [
            'pegawaiList' => $pegawaiList
        ]);
    }

    public function storePengajuan(Request $request): RedirectResponse
    {
        $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'status_kehadiran' => 'required|in:S,I,H,T,CT',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('attendances')->where(function ($query) use ($request) {
                    return $query->where('pegawai_id', $request->pegawai_id);
                })
            ],
            'keterangan' => 'required|string|min:5',
            'jam_masuk' => 'nullable|required_if:status_kehadiran,H|required_if:status_kehadiran,T|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after_or_equal:jam_masuk',
            'file_lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'pegawai_id.required' => 'Anda harus memilih pegawai.',
            'tanggal.unique' => 'Pegawai tersebut SUDAH MEMILIKI data absensi pada tanggal ini.',
        ]);


        $filePath = null;
        if ($request->hasFile('file_lampiran')) {
            $filePath = $request->file('file_lampiran')->store('lampiran_pengajuan', 'public');
        }

        Attendance::create([
            'pegawai_id' => $request->pegawai_id,
            'lokasi_id' => null,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status_kehadiran' => $request->status_kehadiran,
            'status_persetujuan' => 'Approved', 
            'keterangan' => '(Dibuat oleh Admin) ' . $request->keterangan,
            'file_lampiran' => $filePath,
        ]);
        $notif = [
            'title'   => 'Pengajuan Dibuat',
            'message' => 'Data absensi baru telah berhasil dibuat dan disetujui.'
        ];
        return back()->with('success', $notif);
    }
}