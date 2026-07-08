<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rppm;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;

class MonitoringGuruController extends Controller
{
    public function index(Request $request)
    {
        $taAktif = TahunAjaran::getActive();

        $gurus = User::guru()
            ->active()
            ->with('kelas:id,name,guru_id')
            ->get(['id', 'name', 'no_telp']);

        $rppmStats = Rppm::where('tahun_ajaran_id', $taAktif?->id)
            ->whereIn('guru_id', $gurus->pluck('id'))
            ->select('guru_id', 'status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('guru_id', 'status')
            ->get()
            ->groupBy('guru_id');

        $totalMinggu = 17;

        $guruData = $gurus->map(function ($guru) use (
            $rppmStats, $totalMinggu
        ) {
            $rppmGuru  = $rppmStats[$guru->id] ?? collect();
            $rppmTotal = $rppmGuru->sum('jumlah');
            $rppmDisetujui  = $rppmGuru->where('status', 'disetujui')->sum('jumlah');
            $rppmPending    = $rppmGuru->where('status', 'pending')->sum('jumlah');

            $progress = $totalMinggu > 0 ? round(($rppmDisetujui / $totalMinggu) * 100) : 0;
            if ($progress > 100) $progress = 100;

            return [
                'guru'           => $guru,
                'kelas'          => $guru->kelas->name ?? '-',
                'rppm_total'     => $rppmTotal,
                'rppm_disetujui' => $rppmDisetujui,
                'rppm_pending'   => $rppmPending,
                'progress'       => $progress,
            ];
        })->sortByDesc('progress')->values();

        if ($request->filled('cari')) {
            $keyword  = strtolower($request->cari);
            $guruData = $guruData->filter(
                fn($g) => str_contains(strtolower($g['guru']->name), $keyword)
            )->values();
        }

        return view('pages.monitoring_guru.index', compact(
            'guruData',
            'taAktif',
            // 'aspeks',
            'totalMinggu',
        ));
    }
}