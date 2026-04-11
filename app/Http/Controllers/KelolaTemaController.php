<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class KelolaTemaController extends Controller
{
    public function index()
    {
        return view('pages.kelola_tema.index');
    }
}
