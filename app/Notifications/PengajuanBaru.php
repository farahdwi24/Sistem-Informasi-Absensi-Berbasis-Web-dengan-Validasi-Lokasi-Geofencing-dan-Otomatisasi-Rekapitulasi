<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Attendance; 

class PengajuanBaru extends Notification 
{

    protected $attendance;

    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Pengajuan ' . $this->attendance->status_kehadiran . ' baru dari ' . $this->attendance->pegawai->nama_lengkap,
            'url' => route('admin.persetujuan.index'), 
            'icon' => 'inbox',
        ];
    }
}