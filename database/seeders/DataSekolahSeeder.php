<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataSekolah;

class DataSekolahSeeder extends Seeder
{
    public function run(): void
    {
        DataSekolah::updateOrCreate(
            [
                'name'     => 'PAUDQu AL-AULIA',
                'npsn'     => '69990123',
                'no_telp'  => '081234567890',
                'alamat'   => 'Jl. Al-Quran No.12, Serang, Banten',
            ]
        );
    }
}
