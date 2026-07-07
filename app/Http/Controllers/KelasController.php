<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function data() {
        if (Kelas::count() === 0) {
            $kelasDefault = ['Kelas A', 'Kelas B', 'Kelas C', 'Kelas D'];
            foreach($kelasDefault as $k) {
                Kelas::firstOrCreate(['name' => $k]);
            }
        }
        
        $data = Kelas::select(['id', 'name', 'guru_id'])->get();

        return response()->json($data);
    }
}
