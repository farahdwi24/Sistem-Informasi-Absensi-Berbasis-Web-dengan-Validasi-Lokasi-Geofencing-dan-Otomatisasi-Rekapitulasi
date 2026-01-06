<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PruneOldNotifications extends Command
{
    protected $signature = 'notifications:prune';
    protected $description = 'Hapus notifikasi database yang lebih tua dari 30 hari';

    public function handle()
    {
        $this->info('Menghapus notifikasi lama...');
        DB::table('notifications')
            ->where('created_at', '<', Carbon::now()->subDays(30))
            ->delete();

        $this->info('Selesai menghapus notifikasi lama.');
        return 0;
    }
}