<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Pengguna
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::patch('/users/{user}/toggle-aktif', [UserController::class, 'toggleAktif']);

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::post('/siswa', [SiswaController::class, 'store']);
    Route::get('/siswa/{siswa}', [SiswaController::class, 'show']);
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update']);
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy']);

    // Tahun Ajaran
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index']);
    Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store']);
    Route::patch('/tahun-ajaran/{tahunAjaran}/set-aktif', [TahunAjaranController::class, 'setAktif']);

    // Sekolah
    Route::get('/sekolah', [SekolahController::class, 'show']);
    Route::put('/sekolah', [SekolahController::class, 'update']);
});

/*
|--------------------------------------------------------------------------
| Kepala Sekolah Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:kepala sekolah'])->prefix('kepala-sekolah')->group(function () {
    // akan diisi nanti
});

/*
|--------------------------------------------------------------------------
| Guru Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:guru'])->prefix('guru')->group(function () {
    // akan diisi nanti
});

/*
|--------------------------------------------------------------------------
| Orang Tua Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:orang tua'])->prefix('orang-tua')->group(function () {
    // akan diisi nanti
});
