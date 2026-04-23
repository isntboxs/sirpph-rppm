<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tema;
use App\Models\SubTema;

class TemaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'      => 'Aku, Makhluq Allah',
                'semester'  => 1,
                'sub_tema'  => ['Allah Tuhanku', 'Identitasku', 'Tubuhku / Aurat', 'Panca Indra'],
            ],
            [
                'name'      => 'Tanah Airku',
                'semester'  => 1,
                'sub_tema'  => ['Identitas Negara', 'Hari Besar Nasional', 'Lambang Negara', 'Elemen Bangsa / Budaya'],
            ],
            [
                'name'      => 'Lingkunganku',
                'semester'  => 1,
                'sub_tema'  => ['Rumahku', 'Keluargaku', 'Masjidku', 'Sekolahku'],
            ],
            [
                'name'      => 'Binatang Ciptaan Allah',
                'semester'  => 2,
                'sub_tema'  => ['Binatang Halal/Haram', 'Binatang Qurban', 'Binatang Buas', 'Serangga', 'Binatang Air & Udara'],
            ],
        ];

        foreach ($data as $item) {
            $tema = Tema::create([
                'name'     => $item['name'],
                'semester' => $item['semester'],
            ]);

            foreach ($item['sub_tema'] as $subNama) {
                SubTema::create([
                    'tema_id' => $tema->id,
                    'name'    => $subNama,
                ]);
            }
        }
    }
}
