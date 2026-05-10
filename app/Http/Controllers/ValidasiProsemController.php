<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Prosem;
use App\Models\TahunAjaran;

class ValidasiProsemController extends Controller
{
    public function index()
    {
        $taAktif = TahunAjaran::getActive();

        $prosems = Prosem::with(['tema', 'subTema', 'tahunAjaran'])
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->orderBy('minggu_ke')
            ->get()
            ->groupBy('tema_id');

        $pendingCount = Prosem::where('tahun_ajaran_id', $taAktif?->id)
            ->menunggu()
            ->count();

        return view('pages.validasi_prosem.index', compact(
            'prosems',
            'taAktif',
            'pendingCount',
        ));
    }

    public function validasi(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status'  => 'required|in:valid,invalid',
            'catatan' => 'required_if:status,invalid|nullable|string|max:500',
        ], [
            'status.required'           => 'Status wajib dipilih.',
            'catatan.required_if'       => 'Catatan wajib diisi jika status Invalid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $prosem = Prosem::findOrFail((int) $id);

        $prosem->update([
            'status'  => $request->status,
            'catatan' => $request->status === 'invalid' ? $request->catatan : null,
        ]);

        return response()->json([
            'status'  => true,
            'message' => $request->status === 'valid'
                ? '✅ PROSEM minggu ke-' . $prosem->minggu_ke . ' berhasil divalidasi.'
                : '❌ PROSEM dikembalikan ke admin.',
        ]);
    }

    public function validasiSemua(Request $request)
    {
        $taAktif = TahunAjaran::getActive();

        $count = Prosem::where('tahun_ajaran_id', $taAktif?->id)
            ->menunggu()
            ->update(['status' => 'valid', 'catatan' => null]);

        return response()->json([
            'status'  => true,
            'message' => '✅ ' . $count . ' baris PROSEM berhasil divalidasi semua.',
        ]);
    }
}