<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ValidasiKegiatanController extends Controller
{
    public function index()
    {
        return view('pages.validasi_kegiatan.index');
    }
}
