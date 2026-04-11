<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MonitoringGuruController extends Controller
{
    public function index()
    {
        return view('pages.monitoring_guru.index');
    }
}
