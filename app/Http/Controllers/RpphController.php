<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Rpph;
use App\Models\Rppm;
use App\Models\TahunAjaran;

class RpphController extends Controller
{
    public function index()
    {
        $guru    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $rppms = Rppm::with([
            'subTema.tema',
            'rpphs',
            'rppmKegiatans.kegiatan.aspeks',
            'rppmKegiatans.kegiatan.bentukKegiatan',
        ])
            ->olehGuru($guru->id)
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->disetujui()
            ->latest()
            ->get();

        return view('pages.rpph.index', compact('rppms', 'taAktif'));
    }

    public function update(Request $request, int $id)
    {
        $rpph = Rpph::with('rppm')->findOrFail($id);
        abort_if($rpph->rppm->guru_id !== Auth::id(), 403);

        $validator = Validator::make($request->all(), [
            'pembuka' => 'nullable|string',
            'inti'       => 'nullable|string',
            'penutup'       => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $rpph->update($request->only(['pembuka', 'inti', 'penutup']));

        return response()->json([
            'status'  => true,
            'message' => '💾 RPPH berhasil diupdate.',
        ]);
    }

    public function ajukan(int $id)
    {
        $rpph = Rpph::with('rppm')->findOrFail($id);
        abort_if($rpph->rppm->guru_id !== Auth::id(), 403);
        abort_if(!in_array($rpph->status, ['draft', 'dikembalikan']), 422);

        $rpph->update(['status' => 'pending', 'catatan_kepala' => null]);

        return response()->json([
            'status'  => true,
            'message' => '📤 RPPH hari ' . $rpph->hari . ' berhasil diajukan.',
        ]);
    }
}
