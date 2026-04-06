<?php

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
| Protected Routes (by role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Route::get('/dashboard', ...);
    });

    // Kepala Sekolah
    Route::middleware('role:kepala sekolah')->prefix('kepala-sekolah')->group(function () {
        // Route::get('/dashboard', ...);
    });

    // Guru
    Route::middleware('role:guru')->prefix('guru')->group(function () {
        // Route::get('/dashboard', ...);
    });

    // Orang Tua
    Route::middleware('role:orang tua')->prefix('orang-tua')->group(function () {
        // Route::get('/dashboard', ...);
    });
});
