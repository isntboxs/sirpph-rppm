<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Data Sekolah
        Sekolah::firstOrCreate([], [
            'nama' => 'PAUDQu AL-AULIA',
            'npsn' => '69990123',
            'alamat' => 'Jl. Al-Quran No.12, Serang, Banten',
            'kepala_sekolah' => 'Ustadzah Aminah, S.Pd.',
            'telepon' => '0812-3456-7890',
        ]);

        // Tahun Ajaran
        $ta = [
            ['nama' => '2022/2023', 'semester' => 2, 'is_aktif' => false],
            ['nama' => '2023/2024', 'semester' => 2, 'is_aktif' => false],
            ['nama' => '2024/2025', 'semester' => 1, 'is_aktif' => true],
        ];
        foreach ($ta as $item) {
            TahunAjaran::firstOrCreate(['nama' => $item['nama']], $item);
        }

        // Data Siswa
        $siswaData = [
            ['nama' => 'Fatimah Az-Zahra', 'kelas' => 'A', 'tanggal_lahir' => '2019-03-15', 'jenis_kelamin' => 'P'],
            ['nama' => 'Abdullah Hafiz', 'kelas' => 'A', 'tanggal_lahir' => '2018-12-20', 'jenis_kelamin' => 'L'],
            ['nama' => 'Khadijah Rahmah', 'kelas' => 'A', 'tanggal_lahir' => '2019-07-22', 'jenis_kelamin' => 'P'],
            ['nama' => 'Aisyah Nurjannah', 'kelas' => 'B', 'tanggal_lahir' => '2019-05-10', 'jenis_kelamin' => 'P'],
            ['nama' => 'Umar Al-Farouq', 'kelas' => 'B', 'tanggal_lahir' => '2019-01-08', 'jenis_kelamin' => 'L'],
        ];
        foreach ($siswaData as $data) {
            Siswa::firstOrCreate(['nama' => $data['nama']], $data);
        }

        // Relasi ortu → siswa
        $ortu = User::where('username', 'ortu1')->first();
        if ($ortu) {
            $siswaIds = Siswa::whereIn('nama', ['Fatimah Az-Zahra', 'Abdullah Hafiz'])->pluck('id');
            $ortu->siswa()->syncWithoutDetaching($siswaIds);
        }
    }
}
