<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $sekolah = Sekolah::first();
        $tahunAktif = TahunAjaran::where('is_aktif', true)->first();

        return response()->json([
            'stats' => [
                'guru' => User::role('guru')->where('is_aktif', true)->count(),
                'siswa' => Siswa::count(),
                'orang_tua' => User::role('orang tua')->where('is_aktif', true)->count(),
            ],
            'pengguna_per_role' => [
                'admin' => User::role('admin')->count(),
                'kepala sekolah' => User::role('kepala sekolah')->count(),
                'guru' => User::role('guru')->count(),
                'orang tua' => User::role('orang tua')->count(),
            ],
            'sekolah' => $sekolah,
            'tahun_ajaran_aktif' => $tahunAktif,
        ]);
    }
}
