<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DataSekolahController extends Controller
{
    public function index()
    {
        return view('pages.data_sekolah.index');
    }
}
