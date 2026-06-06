<?php


use App\Http\Controllers\AkunUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarAlatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailAlatController;
use App\Http\Controllers\JenisAlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TipeAlatController;
use App\Models\AkunUser;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login');
Route::post('/', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [DashboardController::class, 'dashboardAdmin'])->name('dashboardAdmin.index');
    Route::get('/permintaan-peminjaman', [DashboardController::class, 'permintaanPinjam'])->name('permintaanPinjam.index');
    Route::get('/tracking-alat', [DashboardController::class, 'tracking'])->name('tracking.index');

    Route::view('/add-siswa', 'admin.siswa.add')->name('siswa.add');
    Route::post('/store-siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/update-siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::post('/siswa/check-nis', [SiswaController::class, 'checkNis']);
    Route::post('/tahun-ajaran-baru', [SiswaController::class, 'tahunAjaranBaru'])->name('siswa.tahunAjaranBaru');
    Route::delete('delete-siswa/{id}', [SiswaController::class, 'delete'])->name('siswa.delete');
    Route::post('/import-siswa', [SiswaController::class, 'import'])->name('siswa.import');

    Route::get('/data-akun', [AkunUserController::class, 'akunIndex'])->name('akun.index');
    Route::view('/add-akun', 'admin.akun.add')->name('akun.add');
    Route::post('/store-akun', [AkunUserController::class, 'store'])->name('akun.store');
    Route::put('/update-akun/{id}', [AkunUserController::class, 'update'])->name('akun.update');
    Route::delete('/delete-akun/{id}', [AkunUserController::class, 'delete'])->name('akun.delete');
    Route::get('/export-akun-user', [AkunUserController::class, 'exportPdf'])->name('akun.export');

    Route::get('/data-jenis', [JenisAlatController::class, 'jenisIndex'])->name('jenis.index');
    Route::post('/store-jenis', [JenisAlatController::class, 'store'])->name('jenis.store');
    Route::put('/update-jenis/{id}', [JenisAlatController::class, 'update'])->name('jenis.update');
    Route::post('/jenis/check-nama-jenis', [JenisAlatController::class, 'checkNama']);
    Route::delete('/delete-jenis/{id}', [JenisAlatController::class, 'delete'])->name('jenis.delete');

    Route::get('/add-tipe', [TipeAlatController::class, 'add'])->name('tipe.add');
    Route::post('/store-tipe', [TipeAlatController::class, 'store'])->name('tipe.store');
    Route::put('/update-tipe/{id}', [TipeAlatController::class, 'update'])->name('tipe.update');
    Route::post('/tipe/check-nama-tipe', [TipeAlatController::class, 'checkNamaTipe'])->name('tipe.checkNama');
    Route::delete('/delete-tipe/{id}', [TipeAlatController::class, 'delete'])->name('tipe.delete');

    Route::get('/data-detail/{id}', [DetailAlatController::class, 'detailIndex'])->name('detail.index');
    Route::post('/store-detail/{id}', [DetailAlatController::class, 'store'])->name('detail.store');
    Route::put('/update-detail/{id}', [DetailAlatController::class, 'update'])->name('detail.update');
    Route::delete('/delete-detail/{id}', [DetailAlatController::class, 'delete'])->name('detail.delete');
    Route::get('/export-detail/{id}', [DetailAlatController::class, 'exportPdf'])->name('detail.export');

    Route::get('/data-peminjaman', [PeminjamanController::class, 'adminIndex'])->name('peminjamanAdmin.index');
    Route::put('/validasi/{id}', [PeminjamanController::class, 'validasi'])->name('prosesPengembalian.validasi');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard-siswa', [DashboardController::class, 'dashboardSiswa'])->name('dashboardSiswa.index');

    Route::get('/profile', [AkunUserController::class, 'profile'])->name('profile.index');
    Route::put('/update-password/{id}', [AkunUserController::class, 'updatePasswordProfile'])->name('profile.updatePassword');
    Route::put('/update-username/{id}', [AkunUserController::class, 'updateUsernameProfile'])->name('profile.updateUsername');

    // Route::get('/daftar-alat', [DaftarAlatController::class, 'indexSiswa'])->name('alat.index');
    Route::post('/peminjaman/store-tipe', [PeminjamanController::class, 'prosesPemesananAlat'])->name('peminjamanTipe.store');

    Route::get('/peminjaman', [PeminjamanController::class, 'siswaIndex'])->name('peminjamanSiswa.index');
    Route::get('/peminjaman-scan/{id}', [PeminjamanController::class, 'scanPinjamIndex'])->name('peminjaman.scan');
    Route::post('/peminjaman/store-detail/{id}', [PeminjamanController::class, 'prosesPeminjamanScan'])->name('peminjamanDetail.store');
    Route::get('/proses-pengembalian/{id}', [PeminjamanController::class, 'scanKembaliIndex'])->name('peminjamanSiswa.prosesPengembalian');
    Route::put('/proses-pengembalian/{id}', [PeminjamanController::class, 'prosesPengembalianScan'])->name('prosesPengembalian.scan');
    Route::get('/scan/{kode}', [PeminjamanController::class, 'scanQrExternal'])->name('scan.qr');
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayatSiswa'])->name('riwayatPinjamSiswa.index');

    Route::post('/save-token', function (Request $request) {

        $user = Auth::user();

        $akunUser = AkunUser::find($user->id_akun_user);

        if ($akunUser->fcm_token !== $request->token) {

            $akunUser->update([
                'fcm_token' => $request->token
            ]);
        }

        return response()->noContent();
    });
});

Route::middleware(['auth', 'role:kabeng'])->group(function () {
    Route::get('/dashboard-kabeng', [DashboardController::class, 'dashboardKabeng'])->name('dashboardKabeng.index');
});

Route::middleware(['auth', 'role:admin,siswa'])->group(function () {
    Route::post('/akun/check-username', [AkunUserController::class, 'checkUsername']);
    Route::get('/daftar-alat', [DaftarAlatController::class, 'daftarAlatIndex'])->name('alat.index');
    Route::get('/check-alat', [DaftarAlatController::class, 'check'])->name('alat.check');
    Route::post('/peminjaman-cancel/{id}', [PeminjamanController::class, 'cancel'])->name('peminjaman.cancel');
});

Route::middleware(['auth', 'role:admin,kabeng'])->group(function () {
    Route::get('/data-siswa', [SiswaController::class, 'siswaIndex'])->name('siswa.index');
    Route::get('/data-tipe', [TipeAlatController::class, 'tipeIndex'])->name('tipe.index');
    Route::get('/data-riwayat-peminjaman', [PeminjamanController::class, 'riwayatAdminKabeng'])->name('riwayatPinjamAdminKabeng.index');
    Route::get('/data-kondisi-alat-bermasalah', [TipeAlatController::class, 'kondisiAlatIndex'])->name('kondisiAlat.index');
    Route::get('/export-laporan-siswa', [SiswaController::class, 'exportLaporanSiswa']);
    Route::get('/export-laporan-alat', [TipeAlatController::class, 'exportLaporanAlat']);
    Route::get('/export-laporan-peminjaman', [PeminjamanController::class, 'exportLaporanPeminjaman']);
    Route::get('/export-laporan-kondisi', [TipeAlatController::class, 'exportKondisi']);
});




// Route::post('/save-token', function (Request $request) {
//     $user = Auth::user();

//     AkunUser::where('id_akun_user', $user->id_akun_user)
//         ->update([
//             'fcm_token' => $request->input('token')
//         ]);

//     return response()->json([
//         'success' => true
//     ]);
// })->middleware('auth', 'role:siswa');


// Route::get('/detail-alat/{kode}', function ($kode) {
//     $detail = DetailAlat::with('tipe.jenis')->where('kode_alat', $kode)->firstOrFail();

//     return response()->json([
//         'kode_alat' => $detail->kode_alat,
//         'jenis' => $detail->tipe->jenis->nama_jenis,
//         'tipe' => $detail->tipe->nama_tipe,
//         'kondisi' => $detail->kondisi_alat,
//         'lokasi' => $detail->tipe->lokasi_rak,
//         'status' => $detail->status_alat
//     ]);
// });
