<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PeringatanLupaAbsen extends Notification
{
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Peringatan: Anda belum melakukan absen masuk hari ini.',
            'url' => route('dashboard'), 
            'icon' => 'warning',
            'color' => 'text-danger',
        ];
    }
}