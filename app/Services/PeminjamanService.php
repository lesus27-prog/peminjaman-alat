<?php

namespace App\Services;

use App\Models\DetailAlat;
use App\Models\Peminjaman;
use App\Services\FCMService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

class PeminjamanService
{
    // public function updateStatus(Peminjaman $peminjaman)
    // {
    //     $waktuPakai = CarbonImmutable::parse(
    //         $peminjaman->tanggal_mulai . ' ' . $peminjaman->jam_mulai
    //     );

    //     $waktuSelesai = CarbonImmutable::parse(
    //         $peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai
    //     );

    //     $batasMulai = $waktuPakai->subMinutes(10);

    //     $sekarang = now();

    //     if ($sekarang->greaterThan($waktuSelesai)) {
    //         $statusBaru = 'batal';
    //     } elseif ($sekarang->greaterThanOrEqualTo($batasMulai)) {
    //         $statusBaru = 'siap diambil';
    //     } else {
    //         $statusBaru = 'menunggu';
    //     }

    //     if ($peminjaman->status_pinjam !== $statusBaru) {

    //         $peminjaman->update(['status_pinjam' => $statusBaru]);

    //         if ($statusBaru === 'siap diambil' && $peminjaman->pickup_notif_status === 'pending') {

    //             $token = $peminjaman->siswa?->akunUser?->fcm_token;

    //             if (!$token) {
    //                 $peminjaman->update([
    //                     'pickup_notif_status' => 'failed'
    //                 ]);
    //                 return;
    //             }
    //             $link = '/peminjaman-scan/' . $peminjaman->id_pinjam;
    //             $sent = FCMService::send(
    //                 $token,
    //                 "Alat Siap Diambil [#PJM-0$peminjaman->id_pinjam]",
    //                 "Silakan datang ke ruang peminjaman untuk mengambil alat",
    //                 $link,
    //                 3600

    //             );

    //             $peminjaman->update([
    //                 'pickup_notif_status' => $sent ? 'success' : 'failed'
    //             ]);
    //         }
    //     }
    // }

    public function updateStatus(Peminjaman $peminjaman)
    {
        $waktuPakai = CarbonImmutable::parse(
            $peminjaman->tanggal_mulai . ' ' . $peminjaman->jam_mulai
        );

        $waktuSelesai = CarbonImmutable::parse(
            $peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai
        );

        $batasMulai = $waktuPakai->subMinutes(10);

        $sekarang = now();

        if ($sekarang->greaterThan($waktuSelesai)) {
            $statusBaru = 'batal';
        } elseif ($sekarang->greaterThanOrEqualTo($batasMulai)) {
            $statusBaru = 'siap diambil';
        } else {
            $statusBaru = 'menunggu';
        }

        if ($peminjaman->status_pinjam !== $statusBaru) {

            $peminjaman->update(['status_pinjam' => $statusBaru]);

            if ($statusBaru === 'siap diambil') {
                $this->sendPickupNotification($peminjaman);
            }
        }
    }

    public function sendPickupNotification(Peminjaman $peminjaman)
    {
        if ($peminjaman->pickup_notif_status !== 'pending') {
            return;
        }

        $token = $peminjaman->siswa?->akunUser?->fcm_token;

        if (!$token) {
            $peminjaman->update([
                'pickup_notif_status' => 'failed'
            ]);
            return;
        }

        $link = '/peminjaman-scan/' . $peminjaman->id_pinjam;

        $sent = FCMService::send(
            $token,
            "Alat Siap Diambil [#PJM-0$peminjaman->id_pinjam]",
            "Silakan datang ke ruang peminjaman untuk mengambil alat",
            $link,
            3600
        );

        $peminjaman->update([
            'pickup_notif_status' => $sent ? 'success' : 'failed'
        ]);
    }

    public function checkReminder(Peminjaman $peminjaman)
    {
        $batas = Carbon::parse(
            $peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai
        );

        $sekarang = now();

        $sisaMenit = $sekarang->diffInMinutes($batas, false);

        if ($sisaMenit <= 0 || $sisaMenit > 10) {
            return;
        }

        $this->sendReturnNotification($peminjaman, round($sisaMenit));
    }

    public function sendReturnNotification(Peminjaman $peminjaman, int $sisaMenit)
    {
        $token = $peminjaman->siswa?->akunUser?->fcm_token;

        if (!$token) {
            $peminjaman->update([
                'return_notif_status' => 'failed'
            ]);
            return;
        }

        $link = '/proses-pengembalian/' . $peminjaman->id_pinjam;

        $sent = FCMService::send(
            $token,
            "Reminder Pengembalian [PJM-0$peminjaman->id_pinjam]",
            "Peminjaman akan berakhir dalam {$sisaMenit} menit. Harap segera dikembalikan",
            $link,
            600
        );

        $peminjaman->update([
            'return_notif_status' => $sent ? 'success' : 'failed'
        ]);
    }

    // public function checkReminder(Peminjaman $peminjaman)
    // {
    //     // if ($peminjaman->return_notif_status !== 'pending') {
    //     //     return;
    //     // }

    //     $batas = Carbon::parse(
    //         $peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai
    //     );

    //     $sekarang = now();

    //     $sisaMenit = $sekarang->diffInMinutes($batas, false);

    //     if ($sisaMenit <= 0 || $sisaMenit > 10) {
    //         return;
    //     }

    //     $sisaMenit = round($sisaMenit);

    //     $token = $peminjaman->siswa?->akunUser?->fcm_token;

    //     if (!$token) {
    //         $peminjaman->update([
    //             'return_notif_status' => 'failed'
    //         ]);
    //         return;
    //     }
    //     $link = '/proses-pengembalian/' . $peminjaman->id_pinjam;
    //     $sent = FCMService::send(
    //         $token,
    //         "Reminder Pengembalian [PJM-0$peminjaman->id_pinjam]",
    //         "Peminjaman akan berakhir dalam {$sisaMenit} menit. Harap segera dikembalikan",
    //         $link,
    //         600


    //     );

    //     $peminjaman->update([
    //         'return_notif_status' => $sent ? 'success' : 'failed'
    //     ]);
    // }



    public function prosesPesanAlat($request, AlatService $alatService)
    {
        $check = $alatService->check($request->tanggal_mulai, $request->jam_mulai);
        $alat = $request->input('alat');

        foreach ($alat as $item) {
            $idTipe = $item['id'];
            $qty = $item['jumlah'];

            $stokTersisa = $check[$idTipe] ?? 0;

            if ($qty > $stokTersisa) {
                throw new \Exception();
            }
        }

        $peminjaman = Peminjaman::create([
            'id_siswa' => Auth::user()->siswa->id_siswa,
            'tanggal_mulai' => $request->tanggal_mulai,
            'jam_mulai' => $request->jam_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_selesai' => $request->jam_selesai,
            'pickup_notif_status' => 'pending',
            'return_notif_status' => 'pending',
            'kelas_siswa' => Auth::user()->siswa->kelas
        ]);

        $data = [];

        foreach ($alat as $item) {
            $data[$item['id']] = [
                'quantity' => $item['jumlah']
            ];
        }

        $peminjaman->tipeAlat()->attach($data);

        return $peminjaman;
    }

    public function prosesScanPeminjaman($request, $idPinjam)
    {
        $peminjaman = Peminjaman::findOrFail($idPinjam);

        $kodeAlat = explode(',', $request->alat);

        $detailAlat = DetailAlat::whereIn('kode_alat', $kodeAlat)
            ->pluck('id_detail_alat');

        $dataPivot = [];

        foreach ($detailAlat as $id) {
            $dataPivot[$id] = [
                'tanggal_pengembalian' => null,
                'is_scan_kembali' => false,
                'kondisi_kembali' => null,
                'catatan' => null,
                'is_terlambat' => false
            ];
        }

        $peminjaman->detailAlat()->attach($dataPivot);

        DetailAlat::whereIn('id_detail_alat', $detailAlat)
            ->update(['status_alat' => 'tidak tersedia']);

        $peminjaman->update([
            'status_pinjam' => 'aktif'
        ]);

        return $peminjaman;
    }

    public function externalScanQr($kode)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

        $alat = DetailAlat::where('kode_alat', $kode)->firstOrFail();
        $idSiswa = Auth::user()->siswa->id_siswa;

        $peminjamanAktif = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'aktif')
            ->whereHas('detailAlat', function ($q) use ($alat) {
                $q->where('detail_alat.id_detail_alat', $alat->id_detail_alat);
            })
            // ->latest('id_pinjam')
            ->first();

        if ($peminjamanAktif) {
            return redirect()->route('peminjamanSiswa.prosesPengembalian', [
                'id' => $peminjamanAktif->id_pinjam,
                'kode' => $kode
            ]);
        }

        $peminjaman = Peminjaman::where('id_siswa', $idSiswa)
            ->whereIn('status_pinjam', ['menunggu', 'siap diambil'])
            ->whereHas('tipeAlat', function ($q) use ($alat) {
                $q->where('tipe_alat.id_tipe', $alat->id_tipe);
            })
            ->oldest('id_pinjam')
            ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjamanSiswa.index')
                ->with('errorNotPeminjaman', 'Alat ini tidak ada di daftar peminjaman! Silahkan lakukan peminjaman');
        }

        if ($peminjaman->status_pinjam === 'menunggu') {
            return redirect()->route('peminjamanSiswa.index')
                ->with('errorMenunggu', 'Belum memasuki waktu pemakaian');
        }

        if ($peminjaman->status_pinjam === 'siap diambil') {
            return redirect()->route('peminjaman.scan', [
                'id' => $peminjaman->id_pinjam,
                'kode' => $kode
            ]);
        }

        return redirect()->route('alat.index');
    }

    public function prosesScanPengembalian($request, $idPinjam)
    {
        $peminjaman = Peminjaman::with('detailAlat')->findOrFail($idPinjam);

        $alatData = json_decode($request->alat, true);

        foreach ($alatData as $idTipe => $listKode) {
            foreach ($listKode as $kode) {

                $alat = DetailAlat::where('kode_alat', $kode)->first();

                if ($alat) {
                    $peminjaman->detailAlat()->updateExistingPivot(
                        $alat->id_detail_alat,
                        ['is_scan_kembali' => true]
                    );
                }
            }
        }

        $peminjaman->update([
            'status_pinjam' => 'proses pengembalian'
        ]);

        return $peminjaman;
    }

    public function validasi($request, $id_pinjam)
    {
        $peminjaman = Peminjaman::with('detailAlat')->findOrFail($id_pinjam);

        foreach ($peminjaman->detailAlat as $alat) {

            $idAlat = $alat->id_detail_alat;

            $kondisi = $request->input("kondisi_kembali.$idAlat", 'baik');
            $catatan = $request->input("catatan.$idAlat");

            $status = $kondisi === 'baik' ? 'tersedia' : 'tidak tersedia';

            $peminjaman->detailAlat()->updateExistingPivot($idAlat, [
                // 'is_scan_kembali' => true,
                'kondisi_kembali' => $kondisi,
                'catatan' => $catatan,
                'tanggal_pengembalian' => now(),
                'is_terlambat' => now()->greaterThan(
                    \Carbon\Carbon::parse($peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai)
                )
            ]);

            $alat->update([
                'status_alat' => $status,
                'kondisi_alat' => $kondisi
            ]);
        }

        $peminjaman->update([
            'status_pinjam' => 'selesai'
        ]);

        return $peminjaman;
    }
}
