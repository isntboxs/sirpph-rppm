<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BentukKegiatan;
use App\Models\AlatBahan;

class MasterBentukAlatController extends Controller
{
    public function index()
    {
        $bentuk = BentukKegiatan::orderBy('name')->get();
        $alat   = AlatBahan::orderBy('name')->get();

        return view('pages.master_bentuk_alat.index', compact('bentuk', 'alat'));
    }

    public function storeBentuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:bentuk_kegiatan,name',
        ], [
            'name.required' => 'Nama bentuk kegiatan wajib diisi.',
            'name.unique'   => 'Bentuk kegiatan sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $bentuk = BentukKegiatan::create(['name' => $request->name]);

        return response()->json([
            'status' => true,
            'message' => 'Bentuk kegiatan berhasil ditambahkan.',
        ]);
    }

    public function destroyBentuk(int $id)
    {
        $bentuk = BentukKegiatan::findOrFail($id);
        $bentuk->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Bentuk kegiatan berhasil dihapus.',
        ]);
    }

    public function storeAlat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:alat_bahan,name',
        ], [
            'name.required' => 'Nama alat/bahan wajib diisi.',
            'name.unique'   => 'Alat/bahan sudah ada.',
            'name.max'      => 'Nama maksimal 100 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $alat = AlatBahan::create(['name' => $request->name]);

        return response()->json([
            'status'  => true,
            'message' => 'Alat/bahan berhasil ditambahkan.',
        ]);
    }

    public function destroyAlat(int $id)
    {
        $alat = AlatBahan::findOrFail($id);
        $alat->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Alat/bahan berhasil dihapus.',
        ]);
    }
}
