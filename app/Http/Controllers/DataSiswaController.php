<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class DataSiswaController extends Controller
{
    public function index()
    {
        return view('pages.data_siswa.index');
    }

    public function data() {
        $data = Siswa::select(['id','name'])->where('ortu_id', null)->get();
        return response()->json($data);
    }
}
