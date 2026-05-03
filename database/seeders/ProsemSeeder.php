<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prosem;
use App\Models\TahunAjaran;
use App\Models\Tema;
use App\Models\SubTema;

class ProsemSeeder extends Seeder
{
    public function run(): void
    {
        $ta = TahunAjaran::where('active', true)->firstOrFail();

        $data = [
            ['Aku, Makhluq Allah', 'Allah Tuhanku',      1],
            ['Aku, Makhluq Allah', 'Identitasku',         2],
            ['Aku, Makhluq Allah', 'Tubuhku / Aurat',     3],
            ['Aku, Makhluq Allah', 'Panca Indra',         4],
            ['Tanah Airku',        'Identitas Negara',    5],
            ['Tanah Airku',        'Hari Besar Nasional', 6],
            ['Tanah Airku',        'Lambang Negara',      7],
            ['Tanah Airku',        'Elemen Bangsa / Budaya', 8],
        ];

        foreach ($data as [$temaNama, $subNama, $minggu]) {
            $tema    = Tema::where('name', $temaNama)->firstOrFail();
            $subTema = SubTema::where('name', $subNama)
                ->where('tema_id', $tema->id)
                ->firstOrFail();

            Prosem::create([
                'tahun_ajaran_id' => $ta->id,
                'tema_id'         => $tema->id,
                'sub_tema_id'     => $subTema->id,
                'minggu_ke'       => $minggu,
            ]);
        }
    }
}
