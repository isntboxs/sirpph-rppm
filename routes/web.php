<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KelolaPenggunaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\DataSekolahController;
use App\Http\Controllers\KelolaTemaController;
use App\Http\Controllers\RppmController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ValidasiDataController;
use App\Http\Controllers\LaporanRppController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', fn() => redirect()->route('login'));
/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role'])->group(function () {
    /*
    |----------------------------------------------------------------------
    | Menu Utama (Admin / Semua Role)
    |----------------------------------------------------------------------
    */
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/kelola-pengguna', [KelolaPenggunaController::class, 'index'])->name('kelola_pengguna');
    Route::get('/kelola-pengguna/edit/{id}', [KelolaPenggunaController::class, 'show'])->name('kelola_pengguna.show');
    Route::delete('/kelola-pengguna/{id}', [KelolaPenggunaController::class, 'softDelete'])->name('kelola_pengguna.delete');
    Route::post('/kelola-pengguna', [KelolaPenggunaController::class, 'store'])->name('kelola_pengguna.store');
    Route::put('/kelola-pengguna/{id}', [KelolaPenggunaController::class, 'update'])->name('kelola_pengguna.update');

    Route::get('/kelola-tema', [KelolaTemaController::class, 'index'])->name('kelola_tema');
    Route::post('/kelola-tema', [KelolaTemaController::class, 'store'])->name('kelola_tema.store');
    Route::put('/kelola-tema/{id}', [KelolaTemaController::class, 'update'])->name('kelola_tema.update');
    Route::delete('/kelola-tema/{id}', [KelolaTemaController::class, 'destroy'])->name('kelola_tema.destroy');
    Route::post('/kelola-tema/{id}/ajukan', [KelolaTemaController::class, 'ajukan'])->name('kelola_tema.ajukan');
    Route::post('/kelola-tema/{id}/sub-tema', [KelolaTemaController::class, 'storeSubTema'])->name('kelola_tema.sub.store');
    Route::put('/kelola-tema/sub-tema/{id}', [KelolaTemaController::class, 'updateSubTema'])->name('kelola_tema.sub.update');
    Route::delete('/kelola-tema/sub-tema/{id}', [KelolaTemaController::class, 'destroySubTema'])->name('kelola_tema.sub.destroy');

    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun_ajaran');
    Route::post('/tahun-ajaran', [TahunAjaranController::class, 'create'])->name('tahun_ajaran.create');
    Route::put('/tahun-ajaran/active/{id}', [TahunAjaranController::class, 'active'])->name('tahun_ajaran.active');

    Route::get('/data-sekolah', [DataSekolahController::class, 'index'])->name('data_sekolah');
    Route::put('/data-sekolah/update', [DataSekolahController::class, 'update'])->name('data_sekolah.update');

    /*
    |----------------------------------------------------------------------
    | Kepala Sekolah
    |----------------------------------------------------------------------
    */
    Route::get('/validasi-rppm', [ValidasiDataController::class, 'index'])->name('validasi_rppm');
    Route::put('/validasi-rppm/{id}/setujui', [ValidasiDataController::class, 'setujuiRppm'])->name('validasi_rppm.setujui');
    Route::put('/validasi-rppm/{id}/kembalikan', [ValidasiDataController::class, 'kembalikanRppm'])->name('validasi_rppm.kembalikan');

    Route::get('/validasi-laporan', [App\Http\Controllers\ValidasiLaporanController::class, 'index'])->name('validasi_laporan');
    Route::put('/validasi-laporan/{id}/setujui', [App\Http\Controllers\ValidasiLaporanController::class, 'setujui'])->name('validasi_laporan.setujui');
    Route::put('/validasi-laporan/{id}/kembalikan', [App\Http\Controllers\ValidasiLaporanController::class, 'kembalikan'])->name('validasi_laporan.kembalikan');

    Route::get('/validasi-tema', [App\Http\Controllers\ValidasiTemaController::class, 'index'])->name('validasi_tema');
    Route::put('/validasi-tema/tema/{id}/setujui', [App\Http\Controllers\ValidasiTemaController::class, 'setujuiTema'])->name('validasi_tema.tema.setujui');
    Route::put('/validasi-tema/tema/{id}/kembalikan', [App\Http\Controllers\ValidasiTemaController::class, 'kembalikanTema'])->name('validasi_tema.tema.kembalikan');
    Route::put('/validasi-tema/sub-tema/{id}/setujui', [App\Http\Controllers\ValidasiTemaController::class, 'setujuiSubTema'])->name('validasi_tema.sub_tema.setujui');
    Route::put('/validasi-tema/sub-tema/{id}/kembalikan', [App\Http\Controllers\ValidasiTemaController::class, 'kembalikanSubTema'])->name('validasi_tema.sub_tema.kembalikan');

    Route::get('/monitoring-guru', [App\Http\Controllers\MonitoringGuruController::class, 'index'])->name('monitoring_guru');

    /*
    |----------------------------------------------------------------------
    | Guru
    |----------------------------------------------------------------------
    */
    Route::get('/rppm', [RppmController::class, 'index'])->name('rppm');
    Route::post('/rppm', [RppmController::class, 'store'])->name('rppm.store');
    Route::get('/rppm/create', [RppmController::class, 'create'])->name('rppm.create');
    Route::get('/rppm/{id}', [RppmController::class, 'show'])->name('rppm.show');
    Route::put('/rppm/{id}', [RppmController::class, 'update'])->name('rppm.update');
    Route::put('/rppm/{id}/ajukan', [RppmController::class, 'ajukan'])->name('rppm.ajukan');
    Route::delete('/rppm/{id}', [RppmController::class, 'destroy'])->name('rppm.destroy');

    Route::get('/rppm/{id}/cetak-pdf', [RppmController::class, 'cetakPdf'])->name('rppm.cetak_pdf');
    Route::get('/laporan-rpp', [LaporanRppController::class, 'index'])->name('laporan_rpp');
    Route::get('/laporan-rpp/{id}', [LaporanRppController::class, 'show'])->name('laporan_rpp.show');
    Route::post('/laporan-rpp/{id}', [LaporanRppController::class, 'update'])->name('laporan_rpp.update');

    /*
    |----------------------------------------------------------------------
    | AJAX Data
    |----------------------------------------------------------------------
    */
    Route::get('/sekolah/data', [KelasController::class, 'data'])->name('kelas.data');
    Route::get('/badge/update', [BadgeController::class, 'update'])->name('badge.update');

    /*
    |----------------------------------------------------------------------
    | Notification Route
    |----------------------------------------------------------------------
    */
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::put('/notifikasi/{id}/baca', [NotificationController::class, 'baca'])->name('notifikasi.baca');
    Route::put('/notifikasi/baca-semua', [NotificationController::class, 'bacaSemua'])->name('notifikasi.baca_semua');
    Route::post('/notifikasi/web-push', [NotificationController::class, 'webPush'])->name('notifikasi.web_push');

    /*
    |----------------------------------------------------------------------
    | Cetak Route
    |----------------------------------------------------------------------
    */
    Route::get('/cetak/rppm/{id}', [CetakController::class, 'rppm'])->name('cetak.rppm');
});
