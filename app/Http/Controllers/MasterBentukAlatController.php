<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MasterBentukAlatController extends Controller
{
    public function index()
    {
        return view('pages.master_bentuk_alat.index');
    }
}
