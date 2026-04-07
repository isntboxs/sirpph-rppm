<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function show(): JsonResponse
    {
        $sekolah = Sekolah::firstOrCreate([], [
            'nama' => 'PAUDQu AL-AULIA',
            'npsn' => '69990123',
            'alamat' => 'Jl. Al-Quran No.12, Serang, Banten',
            'kepala_sekolah' => 'Ustadzah Aminah, S.Pd.',
            'telepon' => '0812-3456-7890',
        ]);

        return response()->json(['data' => $sekolah]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'kepala_sekolah' => ['nullable', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:20'],
        ]);

        $sekolah = Sekolah::firstOrCreate([]);
        $sekolah->update($request->only(['nama', 'npsn', 'alamat', 'kepala_sekolah', 'telepon']));

        return response()->json([
            'message' => 'Data sekolah berhasil diperbarui.',
            'data' => $sekolah,
        ]);
    }
}
