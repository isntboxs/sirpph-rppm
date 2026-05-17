<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KelolaPenggunaController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\DataSekolahController;
use App\Http\Controllers\ProsemController;
use App\Http\Controllers\KelolaTemaController;
use App\Http\Controllers\MasterBentukAlatController;
use App\Http\Controllers\ValidasiRppmController;
use App\Http\Controllers\ValidasiRpphController;
use App\Http\Controllers\ValidasiKegiatanController;
use App\Http\Controllers\MonitoringGuruController;
use App\Http\Controllers\KumpulanKegiatanController;
use App\Http\Controllers\RppmController;
use App\Http\Controllers\RpphController;
use App\Http\Controllers\PortofolioSiswaController;
use App\Http\Controllers\AnalisisAspekController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrtuRppmController;
use App\Http\Controllers\OrtuRpphController;
use App\Http\Controllers\OrtuPortoController;
use App\Http\Controllers\ValidasiProsemController;

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

    Route::get('/data-siswa', [DataSiswaController::class, 'index'])->name('data_siswa');

    Route::get('/kelola-tema', [KelolaTemaController::class, 'index'])->name('kelola_tema');
    Route::post('/kelola-tema', [KelolaTemaController::class, 'store'])->name('kelola_tema.store');
    Route::delete('/kelola-tema/{id}', [KelolaTemaController::class, 'destroy'])->name('kelola_tema.destroy');
    Route::post('/kelola-tema/{temaId}/sub-tema', [KelolaTemaController::class, 'storeSubTema'])->name('kelola_tema.sub_tema.store');
    Route::delete('/kelola-tema/sub-tema/{id}', [KelolaTemaController::class, 'destroySubTema'])->name('kelola_tema.sub_tema.destroy');


    Route::get('/master-bentuk-alat', [MasterBentukAlatController::class, 'index'])->name('master_bentuk_alat');
    Route::post('/master-bentuk-alat/bentuk', [MasterBentukAlatController::class, 'storeBentuk'])->name('master_bentuk_alat.bentuk.store');
    Route::delete('/master-bentuk-alat/bentuk/{id}', [MasterBentukAlatController::class, 'destroyBentuk'])->name('master_bentuk_alat.bentuk.destroy');
    Route::post('/master-bentuk-alat/alat', [MasterBentukAlatController::class, 'storeAlat'])->name('master_bentuk_alat.alat.store');
    Route::delete('/master-bentuk-alat/alat/{id}', [MasterBentukAlatController::class, 'destroyAlat'])->name('master_bentuk_alat.alat.destroy');

    Route::get('/prosem', [ProsemController::class, 'index'])->name('prosem');
    Route::post('/prosem', [ProsemController::class, 'store'])->name('prosem.store');
    Route::put('/prosem/{id}', [ProsemController::class, 'update'])->name('prosem.update');
    Route::delete('/prosem/{id}', [ProsemController::class, 'destroy'])->name('prosem.destroy');
    Route::get('/prosem/sub-tema/{temaId}', [ProsemController::class, 'getSubTema'])->name('prosem.sub_tema');

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
    Route::get('/validasi-prosem', [ValidasiProsemController::class, 'index'])->name('validasi_prosem');
    Route::put('/validasi-prosem/{id}', [ValidasiProsemController::class, 'validasi'])->name('validasi_prosem.validasi');
    Route::put('/validasi-prosem/semua/validasi', [ValidasiProsemController::class, 'validasiSemua'])->name('validasi_prosem.semua');

    Route::get('/validasi-rppm', [ValidasiRppmController::class, 'index'])->name('validasi_rppm');
    Route::get('/validasi-rpph', [ValidasiRpphController::class, 'index'])->name('validasi_rpph');

    Route::get('/validasi-rppm', [ValidasiRppmController::class, 'index'])->name('validasi_rppm');
    Route::get('/validasi-rppm/{id}', [ValidasiRppmController::class, 'show'])->name('validasi_rppm.show');
    Route::put('/validasi-rppm/{id}/setujui', [ValidasiRppmController::class, 'setujui'])->name('validasi_rppm.setujui');
    Route::put('/validasi-rppm/{id}/kembalikan', [ValidasiRppmController::class, 'kembalikan'])->name('validasi_rppm.kembalikan');

    Route::get('/validasi-rpph', [ValidasiRpphController::class, 'index'])->name('validasi_rpph');
    Route::get('/validasi-rpph/{id}/detail', [ValidasiRpphController::class, 'show'])->name('validasi_rpph.show');
    Route::put('/validasi-rpph/{id}/setujui', [ValidasiRpphController::class, 'setujui'])->name('validasi_rpph.setujui');
    Route::put('/validasi-rpph/{id}/kembalikan', [ValidasiRpphController::class, 'kembalikan'])->name('validasi_rpph.kembalikan');

    Route::get('/validasi-kegiatan', [ValidasiKegiatanController::class, 'index'])->name('validasi_kegiatan');
    Route::put('/validasi-kegiatan/{id}/setujui', [ValidasiKegiatanController::class, 'setujui'])->name('validasi_kegiatan.setujui');
    Route::put('/validasi-kegiatan/{id}/tolak', [ValidasiKegiatanController::class, 'tolak'])->name('validasi_kegiatan.tolak');
    Route::put('/validasi-kegiatan/{id}/extend', [ValidasiKegiatanController::class, 'extend'])->name('validasi_kegiatan.extend');

    Route::get('/monitoring-guru', [MonitoringGuruController::class, 'index'])->name('monitoring_guru');

    /*
    |----------------------------------------------------------------------
    | Guru
    |----------------------------------------------------------------------
    */
    Route::get('/kumpulan-kegiatan', [KumpulanKegiatanController::class, 'index'])->name('kumpulan_kegiatan');
    Route::post('/kumpulan-kegiatan', [KumpulanKegiatanController::class, 'store'])->name('kumpulan_kegiatan.store');

    Route::get('/rppm', [RppmController::class, 'index'])->name('rppm');
    Route::post('/rppm', [RppmController::class, 'store'])->name('rppm.store');
    Route::get('/rppm/{id}', [RppmController::class, 'show'])->name('rppm.show');
    Route::post('/rppm/{id}/kegiatan', [RppmController::class, 'tambahKegiatan'])->name('rppm.kegiatan.tambah');
    Route::delete('/rppm/kegiatan/{id}', [RppmController::class, 'hapusKegiatan'])->name('rppm.kegiatan.hapus');
    Route::put('/rppm/{id}/ajukan', [RppmController::class, 'ajukan'])->name('rppm.ajukan');
    Route::post('/rppm/{id}/generate-rpph', [RppmController::class, 'generateRpph'])->name('rppm.generate_rpph');
    Route::delete('/rppm/{id}', [RppmController::class, 'destroy'])->name('rppm.destroy');

    Route::get('/rpph', [RpphController::class, 'index'])->name('rpph');
    Route::put('/rpph/{id}', [RpphController::class, 'update'])->name('rpph.update');
    Route::put('/rpph/{id}/ajukan', [RpphController::class, 'ajukan'])->name('rpph.ajukan');
    Route::get('/rpph/tanggal-terpakai/{rppmId}', [RpphController::class, 'tanggalTerpakai'])->name('rpph.tanggal_terpakai');
    Route::get('/rpph/{id}/penilaian', [RpphController::class, 'getPenilaian'])->name('rpph.penilaian');

    Route::get('/portofolio-siswa', [PortofolioSiswaController::class, 'index'])->name('portofolio_siswa');
    Route::post('/portofolio-siswa', [PortofolioSiswaController::class, 'store'])->name('portofolio_siswa.store');
    Route::delete('/portofolio-siswa/{id}', [PortofolioSiswaController::class, 'destroy'])->name('portofolio_siswa.destroy');
    Route::post('/portofolio-siswa/{id}/komentar', [PortofolioSiswaController::class, 'simpanKomentar'])->name('portofolio_siswa.komentar');
    Route::get('/portofolio-siswa/{id}/detail', [PortofolioSiswaController::class, 'show'])->name('portofolio_siswa.show');

    Route::get('/analisis-aspek', [AnalisisAspekController::class, 'index'])->name('analisis_aspek');

    /*
    |----------------------------------------------------------------------
    | Orang Tua
    |----------------------------------------------------------------------
    */
    Route::get('/lihat-rppm', [OrtuRppmController::class, 'index'])->name('ortu_rppm');
    Route::get('/lihat-rppm/{id}/detail', [OrtuRppmController::class, 'show'])->name('ortu_rppm.show');

    Route::get('/lihat-rpph', [OrtuRpphController::class, 'index'])->name('ortu_rpph');
    Route::get('/lihat-rpph', [OrtuRpphController::class, 'index'])->name('ortu_rpph');
    Route::get('/lihat-rpph/{id}/detail', [OrtuRpphController::class, 'show'])->name('ortu_rpph.show');

    Route::get('/portofolio-anak', [OrtuPortoController::class, 'index'])->name('ortu_porto');
    Route::get('/portofolio-anak/{id}/detail', [OrtuPortoController::class, 'show'])->name('ortu_porto.show');
    Route::post('/portofolio-anak/{id}/komentar', [OrtuPortoController::class, 'simpanKomentar'])->name('ortu_porto.komentar');

    /*
    |----------------------------------------------------------------------
    | AJAX Data
    |----------------------------------------------------------------------
    */
    Route::get('/sekolah/data', [KelasController::class, 'data'])->name('kelas.data');
    Route::get('/siswa/data', [DataSiswaController::class, 'data'])->name('siswa.data');
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
