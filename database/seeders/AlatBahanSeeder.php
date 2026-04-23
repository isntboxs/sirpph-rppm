<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlatBahan;

class AlatBahanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Crayon',
            'Spidol',
            'Pensil',
            'Kertas HVS',
            'Kertas Origami',
            'Gunting',
            'Lem',
            'Cat Air',
            'Kuas',
            'LKA',
            'Sajadah',
        ];

        foreach ($data as $name) {
            AlatBahan::create(['name' => $name]);
        }
    }
}
