<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanRpp;
use App\Notifications\GeneralNotification;

class ValidasiLaporanController extends Controller
{
    public function index()
    {
        $taAktif = \App\Models\TahunAjaran::getActive();
        
        $laporanPending = LaporanRpp::with(['guru', 'rppm' => function($q) {
            $q->select('id', 'tahun_ajaran_id', 'sub_tema_id', 'minggu_ke');
        }, 'rppm.subTema.tema'])
            ->whereHas('rppm', function($q) use ($taAktif) {
                $q->where('tahun_ajaran_id', $taAktif?->id);
            })
            ->whereIn('status', ['pending', 'dikembalikan', 'disetujui'])
            ->latest()
            ->paginate(10);

        $stats = [
            'pending' => LaporanRpp::whereHas('rppm', function($q) use ($taAktif) {
                $q->where('tahun_ajaran_id', $taAktif?->id);
            })->where('status', 'pending')->count(),
            'disetujui' => LaporanRpp::whereHas('rppm', function($q) use ($taAktif) {
                $q->where('tahun_ajaran_id', $taAktif?->id);
            })->where('status', 'disetujui')->count(),
        ];

        return view('pages.validasi_laporan.index', compact('laporanPending', 'stats', 'taAktif'));
    }

    public function setujui(Request $request, $id)
    {
        $laporan = LaporanRpp::findOrFail($id);
        
        if ($laporan->status === 'dikembalikan') {
            return response()->json([
                'status' => false,
                'message' => 'Laporan sudah dikembalikan untuk revisi.'
            ], 422);
        }
        
        $laporan->update(['status' => 'disetujui']);

        $laporan->guru->notify(new GeneralNotification(
            'Laporan RPP Disetujui',
            'Laporan RPP untuk minggu ke-' . $laporan->rppm->minggu_ke . ' telah disetujui.',
            route('laporan_rpp.show', $laporan->id)
        ));

        return response()->json([
            'status' => true,
            'message' => 'Laporan berhasil disetujui.'
        ]);
    }

    public function kembalikan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        $laporan = LaporanRpp::findOrFail($id);
        $laporan->update([
            'status' => 'dikembalikan',
            'catatan_kepala' => $request->catatan
        ]);

        $laporan->guru->notify(new GeneralNotification(
            'Laporan RPP Dikembalikan',
            'Laporan RPP minggu ke-' . $laporan->rppm->minggu_ke . ' dikembalikan. Catatan: ' . $request->catatan,
            route('laporan_rpp.show', $laporan->id)
        ));

        return response()->json([
            'status' => true,
            'message' => 'Laporan berhasil dikembalikan ke guru.'
        ]);
    }
}
