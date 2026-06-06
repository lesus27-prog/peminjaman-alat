<?php

namespace App\Services;

use App\Models\TipeAlat;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TipeAlatService
{
    public function generateQr(TipeAlat $tipeAlat, $jumlah)
    {
        $lastDetail = $tipeAlat->detailAlat()->orderBy('kode_alat', 'desc')->first();

        if ($lastDetail) {
            $lastNumber = (int) substr($lastDetail->kode_alat, -3);
        } else {
            $lastNumber = 0;
        }

        for ($i = 1; $i <= $jumlah; $i++) {
            $index = $lastNumber + $i;
            $kode_alat = 'T' . $tipeAlat->id_tipe . '-' . str_pad($index, 3, '0', STR_PAD_LEFT);
            $qrPath = 'qrcodes/qr' . $kode_alat . '.png';

            $fullPath = storage_path('app/public/' . $qrPath);
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0777, true);
            }

            $tipeAlat->detailAlat()->create([
                'kode_alat' => $kode_alat,
                'kondisi_alat' => 'baik',
                'qr_code' => $qrPath,
                'status_alat' => 'tersedia'
            ]);

            $url = route(
                'scan.qr',
                $kode_alat
            );

            QrCode::format('png')
                ->errorCorrection('Q')
                ->size(400)
                ->margin(2)
                ->generate(
                    $url,
                    $fullPath
                );
        }
    }

 
}
