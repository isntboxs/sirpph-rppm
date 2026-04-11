<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class OrtuPortoController extends Controller
{
    public function index()
    {
        return view('pages.ortu_porto.index');
    }
}
