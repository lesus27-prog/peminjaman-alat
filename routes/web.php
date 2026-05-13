<?php


use App\Http\Controllers\AkunUserController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailAlatController;
use App\Http\Controllers\JenisAlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TipeAlatController;
use App\Models\AkunUser;
use App\Models\DetailAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');





Route::get('/', function () {
    return 'Laravel Railway Berhasil';
});



Route::middleware(['role:admin'])->group(function () {

    Route::get('/dashboard-admin', [AlatController::class, 'dashboardAdmin'])->name('dashboardAdmin.index');
    Route::get('/data-siswa', [SiswaController::class, 'siswaIndex'])->name('siswa.index');
    Route::view('/add-siswa', 'admin.siswa.add')->name('siswa.add');
    Route::post('/store-siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/update-siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('delete-siswa/{id}', [SiswaController::class, 'delete'])->name('siswa.delete');
    Route::post('/import-siswa', [SiswaController::class, 'import'])->name('siswa.import');
    Route::get('/export-siswa', [SiswaController::class, 'exportPdf'])->name('siswa.export');

    Route::get('/data-akun', [AkunUserController::class, 'akunIndex'])->name('akun.index');
    Route::view('add-akun', 'admin.akun.add')->name('akun.add');
    Route::post('/store-akun', [AkunUserController::class, 'store'])->name('akun.store');
    Route::put('/update-akun/{id}', [AkunUserController::class, 'update'])->name('akun.update');
    Route::delete('/delete-akun/{id}', [AkunUserController::class, 'delete'])->name('akun.delete');
    Route::get('/export-akun-user', [AkunUserController::class, 'exportPdf'])->name('akun.export');

    Route::get('/data-jenis', [JenisAlatController::class, 'jenisIndex'])->name('jenis.index');
    Route::post('/store-jenis', [JenisAlatController::class, 'store'])->name('jenis.store');
    Route::put('/update-jenis/{id}', [JenisAlatController::class, 'update'])->name('jenis.update');
    Route::delete('/delete-jenis/{id}', [JenisAlatController::class, 'delete'])->name('jenis.delete');
    Route::get('/export-jenis', [JenisAlatController::class, 'exportPdf'])->name('jenis.export');

    Route::get('/data-tipe', [TipeAlatController::class, 'tipeIndex'])->name('tipe.index');
    Route::get('/add-tipe', [TipeAlatController::class, 'add'])->name('tipe.add');
    Route::post('/store-tipe', [TipeAlatController::class, 'store'])->name('tipe.store');
    Route::put('/update-tipe/{id}', [TipeAlatController::class, 'update'])->name('tipe.update');
    Route::delete('/delete-tipe/{id}', [TipeAlatController::class, 'delete'])->name('tipe.delete');
    Route::get('/export-tipe', [TipeAlatController::class, 'exportPdf'])->name('tipe.export');

    Route::get('/data-detail/{id}', [DetailAlatController::class, 'detailIndex'])->name('detail.index');
    Route::post('/store-detail/{id}', [DetailAlatController::class, 'store'])->name('detail.store');
    Route::put('/update-detail/{id}', [DetailAlatController::class, 'update'])->name('detail.update');
    Route::delete('/delete-detail/{id}', [DetailAlatController::class, 'delete'])->name('detail.delete');
    Route::get('/export-detail/{id}', [DetailAlatController::class, 'exportPdf'])->name('detail.export');

    Route::get('/data-peminjaman', [PeminjamanController::class, 'adminIndex'])->name('peminjamanAdmin.index');
    // Route::get('/validasi-index/{id}', [PeminjamanController::class, 'indexValidasi'])->name('prosesPengembalian.index');
    Route::put('/validasi/{id}', [PeminjamanController::class, 'validasi'])->name('prosesPengembalian.validasi');

    // Route::put('/update-kondisi-alat/{id}', [AlatController::class, 'updateKondisiAlat'])->name('kondisiAlat.update');
    Route::get('/tracking-alat', [AlatController::class, 'tracking'])
        ->name('tracking.index');
    Route::get('/permintaan-peminjaman', [AlatController::class, 'permintaanPinjam'])->name('permintaanPinjam.index');

    Route::get('/data-riwayat-peminjaman', [PeminjamanController::class, 'riwayatAdmin'])->name('riwayatPinjamAdmin.index');
    Route::get('/export-riwayat', [PeminjamanController::class, 'exportPdf'])->name('riwayat.export');
    Route::get('/daftar-alat-admin', [AlatController::class, 'indexAdmin'])->name('alatAdmin.index');
});

Route::middleware(['role:siswa'])->group(function () {
    Route::get('/dashboard-siswa', [AlatController::class, 'dashboardSiswa'])->name('dashboardSiswa.index');
    Route::get('/profile', [AkunUserController::class, 'profile'])->name('profile.index');
    Route::put('/update-password/{id}', [AkunUserController::class, 'updatePasswordProfile'])->name('profile.updatePassword');
    Route::put('/update-username/{id}', [AkunUserController::class, 'updateUsernameProfile'])->name('profile.updateUsername');
    Route::get('/peminjaman', [PeminjamanController::class, 'siswaIndex'])->name('peminjamanSiswa.index');
    Route::post('/peminjaman/store-tipe', [PeminjamanController::class, 'storePinjamTipe'])->name('peminjamanTipe.store');
    Route::get('/peminjaman-scan/{id}', [PeminjamanController::class, 'scanPinjamIndex'])->name('peminjaman.scan');
    Route::post('/peminjaman/store-detail/{id}', [PeminjamanController::class, 'storePinjamDetail'])->name('peminjamanDetail.store');
    Route::get('/daftar-alat', [AlatController::class, 'indexSiswa'])->name('alat.index');
    Route::put('/proses-pengembalian/{id}', [PeminjamanController::class, 'scanKembali'])->name('prosesPengembalian.scan');
    Route::get('/proses-pengembalian/{id}', [PeminjamanController::class, 'prosesPengembalianIndex'])->name('peminjamanSiswa.prosesPengembalian');
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayatSiswa'])->name('riwayatPinjamSiswa.index');
    //     Route::get('/siswa/daftar-alat', [DaftarAlatController::class, 'index'])->name('siswa.daftarAlat');
    //     Route::view('/siswa/daftarAlat', 'siswa.daftarAlat.index')->name('alat.index');
    //     
});
Route::middleware(['role:kabeng'])->group(function () {
    Route::get('/dashboard-kabeng', [AlatController::class, 'dashboardKabeng'])->name('dashboardKabeng.index');
    Route::get('/laporan-kondisi-alat', [AlatController::class, 'kondisiAlatKabeng'])->name('kondisiAlatKabeng.index');
    Route::get('/export-kondisi', [AlatController::class, 'exportKondisi'])->name('kondisi.export');
});

Route::get('/check-alat', [AlatController::class, 'check'])->name('alat.check');

Route::get('/scan/{kode}', [PeminjamanController::class, 'scanQr'])
    ->name('scan.qr')
    ->middleware('auth');
Route::post('/peminjaman-cancel/{id}', [PeminjamanController::class, 'cancel'])->name('peminjaman.cancel');

Route::get('/detail-alat/{kode}', function ($kode) {
    $detail = DetailAlat::with('tipe.jenis')->where('kode_alat', $kode)->firstOrFail();

    return response()->json([
        'kode_alat' => $detail->kode_alat,
        'jenis' => $detail->tipe->jenis->nama_jenis,
        'tipe' => $detail->tipe->nama_tipe,
        'kondisi' => $detail->kondisi_alat,
        'lokasi' => $detail->tipe->lokasi_rak,
        'status' => $detail->status_alat
    ]);
});

Route::post('/save-token', function (Request $request) {

    if (!Auth::check()) {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    $user = Auth::user();

    AkunUser::where('id_akun_user', $user->id_akun_user)
        ->update([
            'fcm_token' => $request->input('token')
        ]);

    return response()->json([
        'success' => true
    ]);
})->middleware('auth');


Route::get('/imagick-test', function () {
    return extension_loaded('imagick') ? 'Imagick OK' : 'No Imagick';
});
