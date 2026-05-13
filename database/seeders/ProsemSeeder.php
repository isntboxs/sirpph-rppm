<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProsemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Ambil tahun ajaran aktif
        $tahunAjaranId = TahunAjaran::getActive()?->id;

        if (!$tahunAjaranId) {
            $this->command->warn('Tidak ada tahun ajaran aktif.');
            return;
        }

        $data = [
            // Tema 1 - Aku, Makhluk Allah
            [
                'tema_id'      => 1,
                'sub_tema_id'  => 1, // Allah Tuhanku
                'minggu_ke'    => 1,
            ],
            [
                'tema_id'      => 1,
                'sub_tema_id'  => 2, // Identitasku
                'minggu_ke'    => 2,
            ],
            [
                'tema_id'      => 1,
                'sub_tema_id'  => 3, // Tubuhku / Aurat
                'minggu_ke'    => 3,
            ],
            [
                'tema_id'      => 1,
                'sub_tema_id'  => 4, // Panca Indra
                'minggu_ke'    => 4,
            ],

            // Tema 2 - Tanah Airku
            [
                'tema_id'      => 2,
                'sub_tema_id'  => 5, // Identitas Negara
                'minggu_ke'    => 5,
            ],
            [
                'tema_id'      => 2,
                'sub_tema_id'  => 6, // Hari Besar Nasional
                'minggu_ke'    => 6,
            ],
            [
                'tema_id'      => 2,
                'sub_tema_id'  => 7, // Lambang Negara
                'minggu_ke'    => 7,
            ],
            [
                'tema_id'      => 2,
                'sub_tema_id'  => 8, // Elemen Bangsa / Budaya
                'minggu_ke'    => 8,
            ],

            // Tema 3 - Lingkunganku
            [
                'tema_id'      => 3,
                'sub_tema_id'  => 9, // Rumahku
                'minggu_ke'    => 9,
            ],
            [
                'tema_id'      => 3,
                'sub_tema_id'  => 10, // Keluargaku
                'minggu_ke'    => 10,
            ],
            [
                'tema_id'      => 3,
                'sub_tema_id'  => 11, // Masjidku
                'minggu_ke'    => 11,
            ],
            [
                'tema_id'      => 3,
                'sub_tema_id'  => 12, // Sekolahku
                'minggu_ke'    => 12,
            ],

            // Tema 5 - Kebutuhanku
            [
                'tema_id'      => 5,
                'sub_tema_id'  => 18, // Ibadah
                'minggu_ke'    => 13,
            ],
            [
                'tema_id'      => 5,
                'sub_tema_id'  => 19, // Makanan
                'minggu_ke'    => 14,
            ],
            [
                'tema_id'      => 5,
                'sub_tema_id'  => 20, // Pakaian
                'minggu_ke'    => 15,
            ],
            [
                'tema_id'      => 5,
                'sub_tema_id'  => 21, // Pekerjaan
                'minggu_ke'    => 16,
            ],
            [
                'tema_id'      => 5,
                'sub_tema_id'  => 22, // Alat Komunikasi
                'minggu_ke'    => 17,
            ],
        ];

        $insert = [];

        foreach ($data as $item) {
            $insert[] = [
                'tahun_ajaran_id' => $tahunAjaranId,
                'tema_id'         => $item['tema_id'],
                'sub_tema_id'     => $item['sub_tema_id'],
                'minggu_ke'       => $item['minggu_ke'],
                'status'          => 'valid',
                'catatan'         => null,
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
        }

        DB::table('prosem')->insert($insert);
    }
}
