<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Console\Command;

class UpdatePeminjamanStatus extends Command
{
    protected $signature = 'peminjaman:update-status';
    protected $description = 'Update status peminjaman otomatis';

    public function handle(PeminjamanService $service)
    {
        Peminjaman::whereNotIn('status_pinjam', [
            'batal',
            'selesai',
            'aktif',
            'proses pengembalian'
        ])
            ->chunk(100, function ($data) use ($service) {
                foreach ($data as $pinjam) {
                    $service->updateStatus($pinjam);
                }
            });

        $this->info("OK jalan");
    }
}
