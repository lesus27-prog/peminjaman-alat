<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;

class ReminderPeminjaman extends Command
{
    protected $signature = 'peminjaman:reminder';
    protected $description = 'Reminder peminjaman';

    public function handle(PeminjamanService $service)
    {
        Peminjaman::where('status_pinjam', 'aktif')
            ->where('return_notif_status', 'pending')
            ->chunk(100, function ($data) use ($service) {
                foreach ($data as $pinjam) {
                    $service->checkReminder($pinjam);
                }
            });
    }
}
