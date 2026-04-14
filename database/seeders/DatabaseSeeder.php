<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'active'   => 1,
            'no_telp'  => null,
        ]);

        $kepala = User::create([
            'name'     => 'Ustadzah Aminah, S.Pd.',
            'username' => 'kepala',
            'password' => Hash::make('kepala123'),
            'role'     => 'kepala',
            'active'   => 1,
            'no_telp'  => '0812-0000-0001',
        ]);

        $guruA = User::create([
            'name'     => 'Ustadzah Siti Rahmah',
            'username' => 'guru_a',
            'password' => Hash::make('guru123'),
            'role'     => 'guru',
            'active'   => 1,
            'no_telp'  => '0812-1111-2222',
        ]);

        $guruB = User::create([
            'name'     => 'Ustadzah Dewi Nursanti',
            'username' => 'guru_b',
            'password' => Hash::make('guru123'),
            'role'     => 'guru',
            'active'   => 1,
            'no_telp'  => '0813-3333-4444',
        ]);

        $ortu1 = User::create([
            'name'     => 'Bapak Ahmad Yusuf',
            'username' => 'ortu1',
            'password' => Hash::make('ortu123'),
            'role'     => 'ortu',
            'active'   => 1,
            'no_telp'  => '0814-5555-6666',
        ]);

        $ortu2 = User::create([
            'name'     => 'Ibu Sari Dewi',
            'username' => 'ortu2',
            'password' => Hash::make('ortu123'),
            'role'     => 'ortu',
            'active'   => 1,
            'no_telp'  => '0815-7777-8888',
        ]);

        $kelasA = Kelas::create([
            'name'    => 'Kelas A',
            'guru_id' => $guruA->id,
        ]);

        $kelasB = Kelas::create([
            'name'    => 'Kelas B',
            'guru_id' => $guruB->id,
        ]);

        Siswa::create([
            'kelas_id'      => $kelasA->id,
            'ortu_id'       => $ortu1->id,
            'name'          => 'Zaid Al-Fatih',
            'tanggal_lahir' => '2019-03-15',
            'jenis_kelamin' => 'L',
        ]);

        Siswa::create([
            'kelas_id'      => $kelasA->id,
            'ortu_id'       => $ortu1->id,
            'name'          => 'Aisyah Nur Fadilah',
            'tanggal_lahir' => '2019-07-22',
            'jenis_kelamin' => 'P',
        ]);

        Siswa::create([
            'kelas_id'      => $kelasB->id,
            'ortu_id'       => $ortu2->id,
            'name'          => 'Umar Hakim',
            'tanggal_lahir' => '2019-01-08',
            'jenis_kelamin' => 'L',
        ]);

        Siswa::create([
            'kelas_id'      => $kelasB->id,
            'ortu_id'       => $ortu2->id,
            'name'          => 'Fatimah Az-Zahra',
            'tanggal_lahir' => '2019-05-30',
            'jenis_kelamin' => 'P',
        ]);

        Siswa::create([
            'kelas_id'      => $kelasA->id,
            'ortu_id'       => null,
            'name'          => 'Ibrahim Khalil',
            'tanggal_lahir' => '2018-11-14',
            'jenis_kelamin' => 'L',
        ]);

        Siswa::create([
            'kelas_id'      => $kelasA->id,
            'ortu_id'       => $ortu1->id,
            'name'          => 'Khadijah Rahmah',
            'tanggal_lahir' => '2019-07-22',
            'jenis_kelamin' => 'P',
        ]);
    }
}
