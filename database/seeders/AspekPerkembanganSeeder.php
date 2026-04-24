<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AspekPerkembangan;

class AspekPerkembanganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Nilai Agama & Moral', 'emote' => '🕌', 'warna' => 'a1'],
            ['name' => 'Fisik Motorik',        'emote' => '🏃', 'warna' => 'a2'],
            ['name' => 'Kognitif',             'emote' => '🧠', 'warna' => 'a3'],
            ['name' => 'Bahasa',               'emote' => '💬', 'warna' => 'a4'],
            ['name' => 'Sosial Emosional',     'emote' => '❤️', 'warna' => 'a5'],
            ['name' => 'Seni',                 'emote' => '🎨', 'warna' => 'a6'],
        ];

        foreach ($data as $item) {
            AspekPerkembangan::create($item);
        }
    }
}
