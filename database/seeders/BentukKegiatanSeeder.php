<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BentukKegiatan;

class BentukKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Mewarnai',
            'Menggambar',
            'Melukis',
            'Menggunting',
            'Menempel',
            'Kolase',
            'Finger Painting',
            'Praktek Ibadah',
            'Senam / Olah Raga',
            'Bercerita',
            'Bermain Peran',
            'Playdough',
        ];

        foreach ($data as $name) {
            BentukKegiatan::create(['name' => $name]);
        }
    }
}
