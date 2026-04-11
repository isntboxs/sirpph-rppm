<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        return view('pages.beranda.index');
    }
}
