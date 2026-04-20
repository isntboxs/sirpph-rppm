<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return redirect()->route('login');
// });

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/raw', function () {
//     return view('raw');
// });

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
use App\Http\Controllers\KelasController;
use App\Http\Controllers\OrtuRppmController;
use App\Http\Controllers\OrtuRpphController;
use App\Http\Controllers\OrtuPortoController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Redirect root to beranda
    Route::get('/', fn() => redirect()->route('beranda'));

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
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun_ajaran');
    Route::get('/data-sekolah', [DataSekolahController::class, 'index'])->name('data_sekolah');

    /*
    |----------------------------------------------------------------------
    | Kepala Sekolah
    |----------------------------------------------------------------------
    */
    Route::get('/prosem', [ProsemController::class, 'index'])->name('prosem');
    Route::get('/kelola-tema', [KelolaTemaController::class, 'index'])->name('kelola_tema');
    Route::get('/master-bentuk-alat', [MasterBentukAlatController::class, 'index'])->name('master_bentuk_alat');
    Route::get('/validasi-rppm', [ValidasiRppmController::class, 'index'])->name('validasi_rppm');
    Route::get('/validasi-rpph', [ValidasiRpphController::class, 'index'])->name('validasi_rpph');
    Route::get('/validasi-kegiatan', [ValidasiKegiatanController::class, 'index'])->name('validasi_kegiatan');
    Route::get('/monitoring-guru', [MonitoringGuruController::class, 'index'])->name('monitoring_guru');

    /*
    |----------------------------------------------------------------------
    | Guru
    |----------------------------------------------------------------------
    */
    Route::get('/kumpulan-kegiatan', [KumpulanKegiatanController::class, 'index'])->name('kumpulan_kegiatan');
    Route::get('/rppm', [RppmController::class, 'index'])->name('rppm');
    Route::get('/rpph', [RpphController::class, 'index'])->name('rpph');
    Route::get('/portofolio-siswa', [PortofolioSiswaController::class, 'index'])->name('portofolio_siswa');
    Route::get('/analisis-aspek', [AnalisisAspekController::class, 'index'])->name('analisis_aspek');

    /*
    |----------------------------------------------------------------------
    | Orang Tua
    |----------------------------------------------------------------------
    */
    Route::get('/lihat-rppm', [OrtuRppmController::class, 'index'])->name('ortu_rppm');
    Route::get('/lihat-rpph', [OrtuRpphController::class, 'index'])->name('ortu_rpph');
    Route::get('/portofolio-anak', [OrtuPortoController::class, 'index'])->name('ortu_porto');

    /*
    |----------------------------------------------------------------------
    | AJAX Data
    |----------------------------------------------------------------------
    */
    Route::get('/sekolah/data', [KelasController::class, 'data'])->name('kelas.data');
    Route::get('/siswa/data', [DataSiswaController::class, 'data'])->name('siswa.data');
    
});

