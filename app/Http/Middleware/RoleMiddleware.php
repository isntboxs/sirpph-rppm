<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    protected array $roleRoutes = [
        'admin' => [
            'kelola_pengguna',
            'data_siswa',
            'tahun_ajaran',
            'data_sekolah',
            'kelola_tema',
            'master_bentuk_alat',
            'kelas',
            'siswa',
        ],
        'kepala' => [
            'prosem',
            'validasi_rppm',
            'validasi_rpph',
            'validasi_kegiatan',
            'monitoring_guru',
            'badge'
        ],
        'guru' => [
            'kumpulan_kegiatan',
            'rppm',
            'rpph',
            'portofolio_siswa',
            'analisis_aspek',
        ],
        'ortu' => [
            'ortu_rppm',
            'ortu_rpph',
            'ortu_porto',
        ],
    ];

    // Route yang bisa diakses semua role
    protected array $publicRoutes = [
        'beranda',
        'logout',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $currentRoute = $request->route()->getName();

        // Boleh akses semua public route
        if ($this->isPublicRoute($currentRoute)) {
            return $next($request);
        }

        // Cek apakah route boleh diakses oleh role user
        if ($this->canAccess($user->role, $currentRoute)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }

    private function isPublicRoute(string $routeName): bool
    {
        foreach ($this->publicRoutes as $public) {
            if (str_starts_with($routeName, $public)) {
                return true;
            }
        }
        return false;
    }

    private function canAccess(string $role, string $routeName): bool
    {
        $allowedPrefixes = $this->roleRoutes[$role] ?? [];

        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($routeName, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
