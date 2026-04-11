<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class KumpulanKegiatanController extends Controller
{
    public function index()
    {
        return view('pages.kumpulan_kegiatan.index');
    }
}
