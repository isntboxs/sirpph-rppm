<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TahunAjaranController extends Controller
{
    public function index()
    {
        return view('pages.tahun_ajaran.index');
    }
}
