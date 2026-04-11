<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DataSiswaController extends Controller
{
    public function index()
    {
        return view('pages.data_siswa.index');
    }
}
