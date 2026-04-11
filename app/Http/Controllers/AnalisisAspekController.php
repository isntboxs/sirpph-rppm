<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AnalisisAspekController extends Controller
{
    public function index()
    {
        return view('pages.analisis_aspek.index');
    }
}
