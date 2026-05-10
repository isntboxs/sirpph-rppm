<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Prosem;
use App\Models\Tema;
use App\Models\SubTema;
use App\Models\TahunAjaran;

class ProsemController extends Controller
{
    public function index()
    {
        $taAktif = TahunAjaran::getActive();
        $temas   = Tema::with('subTemas')->orderBy('semester')->get();

        $prosems = Prosem::with(['tema', 'subTema'])
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->orderBy('minggu_ke')
            ->get()
            ->groupBy('tema_id');

        $subTemaTerpakai = Prosem::where('tahun_ajaran_id', $taAktif?->id)
            ->pluck('sub_tema_id')
            ->toArray();

        $tahunAjaranList = TahunAjaran::orderByDesc('active')->get();

        return view('pages.prosem.index', compact(
            'prosems',
            'temas',
            'taAktif',
            'tahunAjaranList',
            'subTemaTerpakai',
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tema_id'         => 'required|exists:tema,id',
            'sub_tema_id'     => 'required|exists:sub_tema,id',
            'minggu_ke'       => 'required|integer|min:1|max:34',
        ], [
            'tema_id.required'     => 'Tema wajib dipilih.',
            'sub_tema_id.required' => 'Sub tema wajib dipilih.',
            'minggu_ke.required'   => 'Minggu ke wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $subTemaSudahAda = Prosem::where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('sub_tema_id', $request->sub_tema_id)
            ->exists();

        if ($subTemaSudahAda) {
            return response()->json([
                'status' => false,
                'errors' => ['sub_tema_id' => ['Sub tema ini sudah dipakai di minggu lain pada semester ini.']],
            ], 422);
        }

        $mingguSudahAda = Prosem::where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('minggu_ke', $request->minggu_ke)
            ->exists();

        if ($mingguSudahAda) {
            return response()->json([
                'status' => false,
                'errors' => ['minggu_ke' => ['Minggu ke-' . $request->minggu_ke . ' sudah dipakai.']],
            ], 422);
        }

        Prosem::create([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'tema_id'         => $request->tema_id,
            'sub_tema_id'     => $request->sub_tema_id,
            'minggu_ke'       => $request->minggu_ke,
            'status'          => 'menunggu',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Baris PROSEM berhasil ditambahkan.',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $prosem = Prosem::findOrFail((int) $id);

        if ($prosem->status === 'valid') {
            return response()->json([
                'status'  => false,
                'message' => 'PROSEM yang sudah valid tidak bisa diedit.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'minggu_ke'   => 'required|integer|min:1|max:34',
            'tema_id'     => 'required|exists:tema,id',
            'sub_tema_id' => 'required|exists:sub_tema,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $mingguBentrok = Prosem::where('tahun_ajaran_id', $prosem->tahun_ajaran_id)
            ->where('minggu_ke', $request->minggu_ke)
            ->where('id', '!=', $prosem->id)
            ->exists();

        if ($mingguBentrok) {
            return response()->json([
                'status' => false,
                'errors' => ['minggu_ke' => ['Minggu ke-' . $request->minggu_ke . ' sudah dipakai.']],
            ], 422);
        }

        // Validasi: sub tema tidak boleh bentrok (kecuali row sendiri)
        $subTemaBentrok = Prosem::where('tahun_ajaran_id', $prosem->tahun_ajaran_id)
            ->where('sub_tema_id', $request->sub_tema_id)
            ->where('id', '!=', $prosem->id)
            ->exists();

        if ($subTemaBentrok) {
            return response()->json([
                'status' => false,
                'errors' => ['sub_tema_id' => ['Sub tema ini sudah dipakai di minggu lain.']],
            ], 422);
        }

        $prosem->update([
            'tema_id'     => $request->tema_id,
            'sub_tema_id' => $request->sub_tema_id,
            'minggu_ke'   => $request->minggu_ke,
            'status'      => 'menunggu',
            'catatan'     => null,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'PROSEM berhasil diupdate dan direset ke menunggu.',
        ]);
    }

    public function destroy(string $id)
    {
        $prosem = Prosem::findOrFail((int) $id);

        if ($prosem->status === 'valid') {
            return response()->json([
                'status'  => false,
                'message' => 'PROSEM yang sudah valid tidak bisa dihapus.',
            ], 422);
        }

        $prosem->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Baris PROSEM berhasil dihapus.',
        ]);
    }

    public function getSubTema(string $temaId, Request $request)
    {
        $taId = $request->query('ta_id');

        $sudahDipakai = Prosem::where('tahun_ajaran_id', $taId)
            ->when(
                $request->query('exclude_id'),
                fn($q, $excludeId) =>
                $q->where('id', '!=', $excludeId)
            )
            ->pluck('sub_tema_id')
            ->toArray();

        $subTemas = SubTema::where('tema_id', $temaId)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn($s) => [
                'id'       => $s->id,
                'name'     => $s->name,
                'terpakai' => in_array($s->id, $sudahDipakai),
            ]);

        return response()->json($subTemas);
    }
}
