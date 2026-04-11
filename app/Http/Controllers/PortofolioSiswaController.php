<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PortofolioSiswaController extends Controller
{
    public function index()
    {
        return view('pages.portofolio_siswa.index');
    }
}
