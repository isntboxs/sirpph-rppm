<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AspekPerkembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rppm;
use App\Models\TahunAjaran;
use App\Notifications\RppmDikembalikan;
use App\Notifications\RppmDisetujui;

class ValidasiRppmController extends Controller
{
    public function index(Request $request)
    {
        $taAktif = TahunAjaran::getActive();

            $pending = Rppm::with([
                'guru:id,name',
                'tahunAjaran:id,name,semester',
                'subTema:id,name,tema_id',
                'subTema.tema:id,name'
            ])
            ->pendingValidasi()
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->latest()
            ->get();

        $query = Rppm::with([
                'guru:id,name',
                'tahunAjaran:id,name',
                'subTema:id,name,tema_id',
                'subTema.tema:id,name',
            ])
            ->whereIn('status', ['disetujui', 'dikembalikan'])
            ->where('tahun_ajaran_id', $taAktif?->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        $riwayat = $query->latest()->paginate(15)->withQueryString();

        $guruList = \App\Models\User::guru()->active()->get(['id', 'name']);

        return view('pages.validasi_rppm.index', compact(
            'pending',
            'riwayat',
            'taAktif',
            'guruList',
        ));
    }

    public function show(int $id)
    {
        $rppm = Rppm::with([
                'guru:id,name,no_telp',
                'guru.kelas:guru_id,name',
                'tahunAjaran:id,name,semester',
                'subTema:id,name,tema_id',
                'subTema.tema:id,name'
            ])
            ->findOrFail($id);

        return view('pages.validasi_rppm.show', compact('rppm'));
    }

    public function setujui(int $id)
    {
        $rppm = Rppm::findOrFail($id);

        if ($rppm->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'RPPM sudah diproses sebelumnya.',
            ], 422);
        }

        $rppm->update([
            'status'         => 'disetujui',
            'catatan_kepala' => null,
        ]);

        $rppm->guru->notify(new RppmDisetujui($rppm));

        return response()->json([
            'status'  => true,
            'message' => '✅ RPPM berhasil disetujui. Guru dapat membuat RPPH.',
        ]);
    }

    public function kembalikan(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'catatan' => 'required|string|max:1000',
        ], [
            'catatan.required' => 'Catatan wajib diisi agar guru tahu apa yang perlu diperbaiki.',
            'catatan.max'      => 'Catatan maksimal 1000 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $rppm = Rppm::findOrFail($id);

        if ($rppm->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'RPPM sudah diproses sebelumnya.',
            ], 422);
        }

        $rppm->update([
            'status'         => 'dikembalikan',
            'catatan_kepala' => $request->catatan,
        ]);

        $rppm->guru->notify(new RppmDikembalikan($rppm));

        return response()->json([
            'status'  => true,
            'message' => '↩️ RPPM dikembalikan ke guru.',
        ]);
    }
}