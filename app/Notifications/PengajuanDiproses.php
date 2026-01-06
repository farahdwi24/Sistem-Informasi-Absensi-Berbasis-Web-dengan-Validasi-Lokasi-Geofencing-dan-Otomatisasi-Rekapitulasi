<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Attendance;

class PengajuanDiproses extends Notification
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
        $statusText = $this->attendance->status_persetujuan == 'Approved' ? 'Disetujui' : 'Ditolak';
        $icon = $this->attendance->status_persetujuan == 'Approved' ? 'check_circle' : 'cancel';
        $color = $this->attendance->status_persetujuan == 'Approved' ? 'text-success' : 'text-danger';

        return [
            'message' => 'Pengajuan ' . $this->attendance->status_kehadiran . ' Anda (' . $this->attendance->tanggal->format('d M Y') . ') telah ' . $statusText,
            'url' => route('absensi.index'), 
            'icon' => $icon,
            'color' => $color,
        ];
    }
}