<?php

namespace App\Http\Controllers;


use App\Models\DetailAlat;
use App\Models\Peminjaman;
use App\Models\TipeAlat;
use App\Services\AlatService;
use App\Services\PeminjamanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function adminIndex(Request $request)
    {
        $tab = $request->get('tab', 'menunggu');

        $peminjamanMenunggu = Peminjaman::where('status_pinjam', 'menunggu')
            ->with('tipeAlat')
            ->get();

        $peminjamanSiapDiambil = Peminjaman::where('status_pinjam', 'siap diambil')
            ->with('tipeAlat')
            ->get();

        $peminjamanAktif = Peminjaman::where('status_pinjam', 'aktif')
            ->with('tipeAlat')
            ->get();

        $peminjamanProsesPengembalian = Peminjaman::where('status_pinjam', 'proses pengembalian')
            ->with([
                'siswa',
                'tipeAlat.detailAlat'
            ])
            ->get();

        $peminjamanBatal = Peminjaman::where('status_pinjam', 'batal')
            ->with('tipeAlat')
            ->get();

        return view('admin.peminjaman.index', compact(
            'tab',
            'peminjamanMenunggu',
            'peminjamanSiapDiambil',
            'peminjamanAktif',
            'peminjamanProsesPengembalian',
            'peminjamanBatal'
        ));
    }

    public function cancel(Request $request, $idPinjam)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($idPinjam);

            $peminjaman->update([
                'status_pinjam' => 'batal'
            ]);

            $routeName = Auth::user()->role === 'admin'
                ? 'peminjamanAdmin.index'
                : 'peminjamanSiswa.index';

            return redirect()
                ->route($routeName, [
                    'tab' => $request->tab ?? 'menunggu'
                ])
                ->with('cancel_success', 'Peminjaman berhasil dibatalkan');
                
        } catch (\Exception $e) {
            $routeName = Auth::user()->role === 'admin'
                ? 'peminjamanAdmin.index'
                : 'peminjamanSiswa.index';

            return redirect()
                ->route($routeName, [
                    'tab' => $request->tab ?? 'menunggu'
                ])
                ->with('cancel_error', 'Peminjaman gagal dibatalkan');
        }
    }

    public function scanPinjamIndex($idPinjam)
    {
        $peminjaman = Peminjaman::with(['tipeAlat.jenisAlat', 'tipeAlat.detailAlat'])->findOrFail($idPinjam);
        $allAlat = DetailAlat::with('tipeAlat')->get();
        return view('siswa.scan', compact('peminjaman', 'allAlat'));
    }

    public function scanQrExternal($kode, PeminjamanService $peminjamanService)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

        return $peminjamanService->externalScanQr($kode);
    }

    public function scanKembaliIndex($idPinjam)
    {
        $peminjaman = Peminjaman::with('detailAlat.tipeAlat')->findOrFail($idPinjam);
        $detailAlat = DetailAlat::all();
        return view('siswa.prosesPengembalian', compact('peminjaman', 'detailAlat'));
    }

    public function validasi(Request $request, PeminjamanService $peminjamanService, $idPinjam)
    {
        $id = "PJM-0" . $idPinjam;
        try {
            DB::beginTransaction();
            $peminjamanService->validasi($request, $idPinjam);
            DB::commit();
            return redirect()
                ->route('peminjamanAdmin.index', ['tab' => 'proses-pengembalian'])
                ->with('validasi_success', $id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('validasi_error', $id);
        }
    }

    public function prosesPengembalianScan(Request $request, PeminjamanService $peminjamanService, $idPinjam)
    {
        try {
            DB::beginTransaction();
            $peminjamanService->prosesScanPengembalian($request, $idPinjam);

            DB::commit();
            return redirect()
                ->route('peminjamanSiswa.index', ['tab' => 'aktif'])
                ->with('prosesPengembalianScan_success', $idPinjam);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('prosesPengembalianScan_error', $idPinjam);
        }
    }

    public function prosesPemesananAlat(Request $request, PeminjamanService $peminjamanService, AlatService $alatService)
    {
        try {
            DB::beginTransaction();
            $peminjaman = $peminjamanService->prosesPesanAlat($request, $alatService);
            DB::commit();
            return redirect()
                ->route('alat.index')
                ->with('prosesPemesananAlat_success', 'Peminjaman berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('prosesPemesananAlat_error', 'Peminjaman gagal dibuat!Silahkan coba lagi');
        }
    }

    public function prosesPeminjamanScan(Request $request, PeminjamanService $peminjamanService, $idPinjam)
    {
        try {
            DB::beginTransaction();
            $peminjamanService->prosesScanPeminjaman($request, $idPinjam);
            DB::commit();
            return redirect()
                ->route('peminjamanSiswa.index', ['tab' => 'siap-diambil'])
                ->with('prosesPeminjamanScan_success', 'Scan alat berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('prosesPeminjamanScan_error', 'Scan alat gagal dilakukan!');
        }
    }

    public function siswaIndex(Request $request)
    {
        $idSiswa = Auth::user()->siswa->id_siswa;
        $tab = $request->get('tab', 'menunggu');

        // $peminjamans = Peminjaman::where('id_siswa', $idSiswa)->get();

        // update status otomatis
        // foreach ($peminjamans as $peminjaman) {
        //     $peminjaman->updateStatus();
        // }

        $peminjamanMenunggu = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'menunggu')
            ->with('tipeAlat')
            ->get();

        $peminjamanSiapDiambil = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'siap diambil')
            ->with('tipeAlat')
            ->get();

        $peminjamanAktif = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'aktif')
            ->with(['tipeAlat', 'detailAlat'])
            ->get();

        $peminjamanProsesPengembalian = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'proses pengembalian')
            ->with('tipeAlat')
            ->get();

        $peminjamanBatal = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'batal')
            ->with('tipeAlat')
            ->get();

        return view('siswa.peminjaman', compact(
            'tab',
            'peminjamanMenunggu',
            'peminjamanSiapDiambil',
            'peminjamanAktif',
            'peminjamanProsesPengembalian',
            'peminjamanBatal'
        ));
    }

    public function riwayatAdminKabeng()
    {
        $tipes = TipeAlat::all();
        $data = Peminjaman::with(['siswa', 'tipeAlat'])
            ->where('status_pinjam', 'selesai')
            ->get();

        $view = Auth::user()->role === 'admin'
            ? 'admin.riwayatPinjam'
            : 'kabeng.laporanPeminjamanIndex';

        return view($view, compact('data', 'tipes'));
    }

    public function riwayatSiswa()
    {
        $siswa = Auth::user()->siswa->id_siswa;
        $tipes = TipeAlat::all();
        $data = Peminjaman::where('status_pinjam', 'selesai')
            ->where('id_siswa', $siswa)
            ->get();

        return view(
            'siswa.riwayatPinjam',
            compact('data', 'tipes')
        );
    }

    public function exportLaporanPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['siswa', 'tipeAlat'])
            ->where('status_pinjam', 'selesai')
            ->orderBy('tanggal_mulai', 'asc');

        if ($request->kelas) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        if ($request->tipe) {
            $query->whereHas('tipeAlat', function ($q) use ($request) {
                $q->where('nama_tipe', $request->tipe);
            });
        }

        if ($request->start && $request->end) {
            $query->whereBetween('tanggal_mulai', [$request->start, $request->end]);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('exportPeminjaman', compact('data'));
        return $pdf->download('Laporan Peminjaman.pdf');
    }
}
