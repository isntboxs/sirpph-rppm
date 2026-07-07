<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Models\SubTema;
use App\Models\Rppm;
use Illuminate\Http\Request;

class ValidasiDataController extends Controller
{
    public function index()
    {
        $taAktif = \App\Models\TahunAjaran::getActive();
        $rppmPending = Rppm::with(['guru.kelas', 'subTema.tema'])
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->whereIn('status', ['pending', 'dikembalikan', 'disetujui'])
            ->latest()
            ->paginate(10);

        return view('pages.validasi_rpp.index', compact('rppmPending'));
    }

    public function setujuiRppm(Request $request, $id)
    {
        $rppm = Rppm::findOrFail($id);
        
        if ($rppm->status === 'dikembalikan') {
            return response()->json([
                'status' => false,
                'message' => 'RPP sudah dikembalikan untuk revisi.'
            ], 422);
        }
        
        $rppm->update(['status' => 'disetujui']);

        $rppm->guru->notify(new \App\Notifications\GeneralNotification(
            'RPP Disetujui',
            'RPP untuk minggu ke-' . $rppm->minggu_ke . ' telah disetujui oleh Kepala Sekolah.',
            route('rppm.show', $rppm->id)
        ));

        return response()->json([
            'status' => true,
            'message' => 'RPP berhasil disetujui.'
        ]);
    }

    public function kembalikanRppm(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        $rppm = Rppm::findOrFail($id);
        $rppm->update([
            'status' => 'dikembalikan',
            'catatan_kepala' => $request->catatan
        ]);

        $rppm->guru->notify(new \App\Notifications\GeneralNotification(
            'RPP Dikembalikan',
            'RPP minggu ke-' . $rppm->minggu_ke . ' dikembalikan. Catatan: ' . $request->catatan,
            route('rppm.show', $rppm->id)
        ));

        return response()->json([
            'status' => true,
            'message' => 'RPP berhasil dikembalikan ke guru.'
        ]);
    }
}
