<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class OrtuRppmController extends Controller
{
    public function index()
    {
        return view('pages.ortu_rppm.index');
    }
}
