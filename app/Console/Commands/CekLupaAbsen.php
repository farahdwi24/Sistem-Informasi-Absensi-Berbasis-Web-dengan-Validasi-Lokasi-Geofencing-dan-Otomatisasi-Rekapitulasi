<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Attendance;
use App\Notifications\PeringatanLupaAbsen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CekLupaAbsen extends Command
{
    protected $signature = 'absensi:cek-lupa';
    protected $description = 'Cek semua pegawai yang belum absen hari ini dan kirim notifikasi';

    public function handle()
    {
        $this->info('Mulai pengecekan lupa absen...');

        $today = Carbon::today();

        $sudahAbsenIds = Attendance::whereDate('tanggal', $today)
                            ->pluck('pegawai_id')
                            ->unique()
                            ->toArray();

        $lupaAbsenUsers = User::where('role_id', '!=', 1)
                            ->whereNotIn('id', $sudahAbsenIds)
                            ->get();

        if ($lupaAbsenUsers->isEmpty()) {
            $this->info('Semua pegawai sudah absen. Tidak ada notifikasi dikirim.');
            return 0;
        }

        $this->info('Mengirim notifikasi ke ' . $lupaAbsenUsers->count() . ' pegawai...');

        Notification::send($lupaAbsenUsers, new PeringatanLupaAbsen());

        $this->info('Selesai.');
        return 0;
    }
}