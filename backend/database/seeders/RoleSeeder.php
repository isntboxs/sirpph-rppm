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
                'name' => 'Admin',
                'email' => 'admin@sirpph.test',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@sirpph.test',
                'password' => bcrypt('password'),
                'role' => 'kepala sekolah',
            ],
            [
                'name' => 'Guru',
                'email' => 'guru@sirpph.test',
                'password' => bcrypt('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'Orang Tua',
                'email' => 'orangtua@sirpph.test',
                'password' => bcrypt('password'),
                'role' => 'orang tua',
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::firstOrCreate(['email' => $data['email']], $data);
            $user->syncRoles([$role]);
        }
    }
}
