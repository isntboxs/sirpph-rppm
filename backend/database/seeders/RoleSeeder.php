<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'kepala sekolah', 'guru', 'orang tua'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Contoh user per role
        $users = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@sirpph.test',
                'password' => bcrypt('admin123'),
                'is_aktif' => true,
                'role' => 'admin',
            ],
            [
                'name' => 'Ustadzah Aminah, S.Pd.',
                'username' => 'kepala',
                'email' => 'kepala@sirpph.test',
                'password' => bcrypt('kepala123'),
                'is_aktif' => true,
                'role' => 'kepala sekolah',
            ],
            [
                'name' => 'Siti Nurhaliza, S.Pd.',
                'username' => 'guru_a',
                'email' => 'guru_a@sirpph.test',
                'password' => bcrypt('guru123'),
                'kelas' => 'A',
                'hp' => '0812-0001-0001',
                'is_aktif' => true,
                'role' => 'guru',
            ],
            [
                'name' => 'Mira Rahayu, S.Pd.',
                'username' => 'guru_b',
                'email' => 'guru_b@sirpph.test',
                'password' => bcrypt('guru123'),
                'kelas' => 'B',
                'hp' => '0812-0002-0002',
                'is_aktif' => true,
                'role' => 'guru',
            ],
            [
                'name' => 'Bapak Ahmad',
                'username' => 'ortu1',
                'email' => 'ortu1@sirpph.test',
                'password' => bcrypt('ortu123'),
                'is_aktif' => true,
                'role' => 'orang tua',
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::firstOrCreate(['username' => $data['username']], $data);
            $user->syncRoles([$role]);
        }
    }
}
