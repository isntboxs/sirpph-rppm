<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'     => '2022/2023',
                'semester' => 2,
                'active'   => false,
            ],
            [
                'name'     => '2023/2024',
                'semester' => 2,
                'active'   => false,
            ],
            [
                'name'     => '2024/2025',
                'semester' => 1,
                'active'   => true,
            ],
        ];

        foreach ($data as $item) {
            TahunAjaran::create($item);
        }
    }
}