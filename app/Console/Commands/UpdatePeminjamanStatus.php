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
        $this->info('Command dijalankan');

        $jumlah = Peminjaman::whereIn('status_pinjam', [
            'menunggu',
            'siap diambil'
        ])->count();

        $this->info("Jumlah data: {$jumlah}");

        Peminjaman::whereIn('status_pinjam', [
            'menunggu',
            'siap diambil'
        ])
            ->chunk(100, function ($data) use ($service) {
                foreach ($data as $pinjam) {
                    $service->updateStatus($pinjam);
                }
            });
    }
}
