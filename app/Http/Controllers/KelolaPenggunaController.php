<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class KelolaPenggunaController extends Controller
{
    public function index()
    {
        return view('pages.kelola_pengguna.index');
    }
}
