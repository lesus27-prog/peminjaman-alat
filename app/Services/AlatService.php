<?php

namespace App\Services;

use App\Models\TipeAlat;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class AlatService
{
    public function check($tglMulai, $jamMulai)
    {
        $tanggalMulai = Carbon::parse($tglMulai);

        $stokTipe = TipeAlat::pluck('stok', 'id_tipe');

        $idTipes = TipeAlat::pluck('id_tipe');

        $peminjaman = DB::table('peminjaman_tipe')
            ->join('peminjaman', 'peminjaman.id_pinjam', '=', 'peminjaman_tipe.id_pinjam')
            ->whereIn('peminjaman.status_pinjam', [
                'menunggu',
                'siap diambil',
                'aktif',
                'proses pengembalian'
            ])
            ->whereDate('peminjaman.tanggal_mulai', '<=', $tanggalMulai)
            ->whereDate('peminjaman.tanggal_selesai', '>=', $tanggalMulai)
            ->select(
                'peminjaman_tipe.id_tipe',
                'peminjaman_tipe.quantity',
                'peminjaman.tanggal_mulai',
                'peminjaman.tanggal_selesai',
                'peminjaman.jam_mulai',
                'peminjaman.jam_selesai'
            )
            ->get()
            ->groupBy('id_tipe');

        $result = [];

        foreach ($idTipes as $idTipe) {

            $stok = $stokTipe[$idTipe] ?? 0;

            $listPinjam = $peminjaman[$idTipe] ?? collect();

            $terpakai = 0;

            foreach ($listPinjam as $item) {

                $tglMulai = Carbon::parse($item->tanggal_mulai);
                $tglSelesai = Carbon::parse($item->tanggal_selesai);

                if (!$tanggalMulai->between($tglMulai, $tglSelesai)) {
                    continue;
                }

                if (
                    $tanggalMulai->isSameDay($tglMulai) &&
                    $jamMulai < $item->jam_mulai
                ) {
                    continue;
                }

                if (
                    $tanggalMulai->isSameDay($tglSelesai) &&
                    $jamMulai >= $item->jam_selesai
                ) {
                    continue;
                }

                $terpakai += $item->quantity;
            }

            $result[$idTipe] = max($stok - $terpakai, 0);
        }

        return $result;
    }
}
