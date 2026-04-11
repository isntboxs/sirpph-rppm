<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ProsemController extends Controller
{
    public function index()
    {
        return view('pages.prosem.index');
    }
}
