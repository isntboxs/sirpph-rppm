<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index(): JsonResponse
    {
        $data = TahunAjaran::orderByDesc('nama')->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'unique:tahun_ajaran,nama'],
            'semester' => ['required', 'integer', 'in:1,2'],
        ]);

        $tahunAjaran = TahunAjaran::create([
            'nama' => $request->nama,
            'semester' => $request->semester,
            'is_aktif' => false,
        ]);

        return response()->json([
            'message' => 'Tahun ajaran berhasil ditambahkan.',
            'data' => $tahunAjaran,
        ], 201);
    }

    public function setAktif(TahunAjaran $tahunAjaran): JsonResponse
    {
        TahunAjaran::where('is_aktif', true)->update(['is_aktif' => false]);
        $tahunAjaran->update(['is_aktif' => true]);

        return response()->json([
            'message' => "Tahun ajaran {$tahunAjaran->nama} semester {$tahunAjaran->semester} sekarang aktif.",
            'data' => $tahunAjaran,
        ]);
    }
}
