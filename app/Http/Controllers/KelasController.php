<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function data() {

        $data = Kelas::select(['id', 'name', 'guru_id'])->get();

        return response()->json($data);
    }
}
