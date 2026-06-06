<?php

namespace App\Services;

use App\Models\DetailAlat;
use App\Models\JenisAlat;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\TipeAlat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function dashboardAdmin()
    {
        $siswa = Siswa::whereHas('akunUser', function ($q) {
            $q->where('status_akun', 'aktif');
        })->count();

        $alat = TipeAlat::sum('stok');

        $alatDipinjam = Peminjaman::whereIn('status_pinjam', ['aktif', 'proses pengembalian'])
            ->with('tipeAlat')
            ->get()
            ->sum(function ($pinjam) {
                return $pinjam->tipeAlat->sum('pivot.quantity');
            });

        $terlambat = Peminjaman::where('status_pinjam', 'aktif')
            ->whereRaw("CONCAT(tanggal_selesai, ' ', jam_selesai) < ?", [now()])
            ->count();

        $summary = DetailAlat::select('kondisi_alat', DB::raw('count(*) as total'))
            ->groupBy('kondisi_alat')
            ->get();

        $detail = DetailAlat::select('kode_alat', 'kondisi_alat', 'id_tipe')
            ->with('tipeAlat')
            ->get();

        return compact(
            'siswa',
            'alat',
            'alatDipinjam',
            'terlambat',
            'summary',
            'detail'
        );
    }

    public function dashboardKabeng()
    {
        $siswa = Siswa::whereHas('akunUser', function ($q) {
            $q->where('status_akun', 'aktif');
        })->count();
        $alat = DetailAlat::where('kondisi_alat', 'baik')->count();
        $jenis = JenisAlat::count();

        $alatBermasalah = DetailAlat::whereIn('kondisi_alat', [
            'rusak',
            'perlu perbaikan',
            'hilang'
        ])->count();

        $summaryJenis = JenisAlat::withCount('tipeAlat')->get();

        $detailJenis = JenisAlat::with('tipeAlat.jenisAlat')->get();

        $topAlat = TipeAlat::withSum([
            'peminjaman as total_dipinjam' => function ($q) {
                $q->where('status_pinjam', 'selesai');
            }
        ], 'peminjaman_tipe.quantity')
            ->orderByDesc('total_dipinjam')
            ->take(5)
            ->get();

        $raw = Peminjaman::selectRaw('MONTH(tanggal_selesai) as bulan, COUNT(*) as total')
            ->whereHas('detailAlat')
            ->groupByRaw('MONTH(tanggal_selesai)')
            ->pluck('total', 'bulan');

        $pinjamBulanan = [];

        for ($i = 1; $i <= 12; $i++) {
            $pinjamBulanan[] = $raw[$i] ?? 0;
        }

        return compact(
            'siswa',
            'alat',
            'jenis',
            'alatBermasalah',
            'summaryJenis',
            'detailJenis',
            'topAlat',
            'pinjamBulanan'
        );
    }

    public function dashboardSiswa()
    {
        $siswaId = Auth::user()->siswa->id_siswa;

        $alatDipinjam = Peminjaman::whereIn('status_pinjam', ['aktif', 'proses pengembalian'])
            ->where('id_siswa', $siswaId)
            ->with('tipeAlat')
            ->get()
            ->sum(fn($pinjam) => $pinjam->tipeAlat->sum('pivot.quantity'));

        $siapDiambil = Peminjaman::where('status_pinjam', 'siap diambil')
            ->where('id_siswa', $siswaId)
            ->count();

        $prosesPengembalian = Peminjaman::where('status_pinjam', 'proses pengembalian')
            ->where('id_siswa', $siswaId)
            ->count();

        $terlambat = Peminjaman::whereIn('status_pinjam', ['aktif', 'proses pengembalian'])
            ->where('id_siswa', $siswaId)
            ->get()
            ->filter(fn($pinjam) => $pinjam->terlambat())
            ->count();

        return compact(
            'alatDipinjam',
            'siapDiambil',
            'prosesPengembalian',
            'terlambat'
        );
    }

    public function tracking($request)
    {
        $alat = DetailAlat::with([
            'tipeAlat',
            'peminjaman' => function ($query) {
                $query->orderBy('tanggal_mulai', 'desc')->orderBy('jam_mulai', 'desc');;
            },
            'peminjaman.siswa',
            'peminjaman.detailAlat'
        ])->where('kode_alat', $request->kode_alat)->first();

        if (!$alat) {
            return response()->json([
                'status' => false,
                'empty' => true,
                'message' => 'Masukkan kode alat yang valid'
            ]);
        }

        $riwayat = [];

        $start = $request->start_date;
        $end = $request->end_date;

        foreach ($alat->peminjaman as $pinjam) {

            if ($start && $pinjam->tanggal_mulai < $start) continue;
            if ($end && $pinjam->tanggal_mulai > $end) continue;

            $pivot = $pinjam->detailAlat
                ->where('id_detail_alat', $alat->id_detail_alat)
                ->first()
                ->pivot ?? null;

            $riwayat[] = [
                'nama' => $pinjam->siswa->nama_siswa,
                'kelas' => $pinjam->siswa->kelas,
                'tanggal' => $pinjam->tanggal_mulai,
                'terlambat' => $pinjam->terlambat() ? 'Terlambat' : 'Tepat Waktu',
                'kondisi' => $pivot->kondisi_kembali ?? '-',
                'catatan' => $pivot->catatan ?? '-'
            ];
        }

        return response()->json([
            'status' => true,
            'data' => [
                'tipe' => $alat->tipeAlat->nama_tipe,
                'kondisi' => $alat->kondisi_alat,
                'status' => $alat->status_alat,
                'dipinjam' => $alat->peminjaman->count(),
                'riwayat' => $riwayat
            ]
        ]);
    }

    public function permintaanPinjam($request)
    {
        $tanggal = $request->tanggal;

        $data = Peminjaman::whereIn('status_pinjam', ['menunggu', 'siap diambil'])
            ->whereDate('tanggal_mulai', $tanggal)
            ->with('tipeAlat')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->jam_mulai)->format('H:i');
            });

        $result = [];

        foreach ($data as $jam => $list) {

            $tipeList = [];

            foreach ($list as $pinjam) {
                foreach ($pinjam->tipeAlat as $tipe) {

                    $nama = $tipe->nama_tipe;

                    if (!isset($tipeList[$nama])) {
                        $tipeList[$nama] = 0;
                    }

                    $tipeList[$nama] += $tipe->pivot->quantity;
                }
            }

            $detail = [];

            foreach ($tipeList as $nama => $qty) {
                $detail[] = [
                    'nama' => $nama,
                    'qty' => $qty
                ];
            }

            $result[] = [
                'jam' => $jam,
                'total_tipe' => count($detail),
                'detail' => $detail
            ];
        }

        return response()->json([
            'data' => $result
        ]);
    }
}
