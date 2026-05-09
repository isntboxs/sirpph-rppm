<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataSekolah;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class DataSekolahController extends Controller
{
    public function index()
    {
        $data = [
            'sekolah'       => DataSekolah::select(['name', 'npsn', 'no_telp', 'alamat'])->first(),
            'kepala'        => User::where('role', 'kepala')->select(['name'])->first(),
            'tahun_ajaran'  => TahunAjaran::Active()->select(['name', 'semester'])->first(),
            'taAktif'       => TahunAjaran::getActive(),
        ];

        return view('pages.data_sekolah.index', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'npsn'   => 'required|string|max:10',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'required|string',
        ]);

        $sekolah = DataSekolah::firstOrNew();

        $sekolah->update($request->only(['name', 'npsn', 'no_telp', 'alamat']));

        return response()->json(['msg' => 'Data Sekolah berhasil diperbarui']);
    }
}
