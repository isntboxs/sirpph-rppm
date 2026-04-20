<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    public function index()
    {
        return view('pages.data_siswa.index');
    }

    public function data(Request $request)
    {
        $user_id = $request->user_id;
        // $data = Siswa::select(['id','name'])->where('ortu_id', null)->get();
        $data = Siswa::select(['id', 'name', 'ortu_id'])
            ->where(function ($query) use ($user_id) {
                $query->whereNull('ortu_id');
                if ($user_id) {
                    $query->orWhere('ortu_id', $user_id);
                }
            })
            ->get();
        return response()->json($data);
    }
}
