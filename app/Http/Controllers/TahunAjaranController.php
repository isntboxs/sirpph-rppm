<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $datas = TahunAjaran::orderByDesc('active')->latest()->get();

        return view('pages.tahun_ajaran.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:20',
            'semester' => 'required|integer|in:1,2',
        ]);

        TahunAjaran::create([
            'name'     => $request->name,
            'active'    => false,
            'semester' => $request->semester,
        ]);

        return response()->json(['msg' => 'Tahun Ajaran berhasil ditambahkan']);
    }

    public function active($id)
    {
        TahunAjaran::query()->update(['active' => false]);

        TahunAjaran::findOrFail($id)->update(['active' => true]);

        return response()->json(['msg' => 'Tahun Ajaran berhasil diaktifkan']);
    }
}
