<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSiswaRequest;
use App\Http\Requests\Admin\UpdateSiswaRequest;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;

class SiswaController extends Controller
{
    public function index(): JsonResponse
    {
        $siswa = Siswa::orderBy('kelas')->orderBy('nama')->get();

        return response()->json(['data' => $siswa]);
    }

    public function store(StoreSiswaRequest $request): JsonResponse
    {
        $siswa = Siswa::create($request->validated());

        return response()->json([
            'message' => 'Data siswa berhasil ditambahkan.',
            'data' => $siswa,
        ], 201);
    }

    public function show(Siswa $siswa): JsonResponse
    {
        return response()->json(['data' => $siswa]);
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa): JsonResponse
    {
        $siswa->update($request->validated());

        return response()->json([
            'message' => 'Data siswa berhasil diperbarui.',
            'data' => $siswa,
        ]);
    }

    public function destroy(Siswa $siswa): JsonResponse
    {
        $siswa->delete();

        return response()->json(['message' => 'Data siswa berhasil dihapus.']);
    }
}
