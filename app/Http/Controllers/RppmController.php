<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class RppmController extends Controller
{
    public function index()
    {
        return view('pages.rppm.index');
    }
}
