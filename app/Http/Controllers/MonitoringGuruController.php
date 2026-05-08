<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rppm;
use App\Models\Rpph;
use App\Models\Portofolio;
use App\Models\Kelas;
use App\Models\AspekPerkembangan;
use App\Models\RppmKegiatan;
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

        $rpphStats = Rpph::whereHas('rppm', fn($q) =>
                $q->where('tahun_ajaran_id', $taAktif?->id)
                  ->whereIn('guru_id', $gurus->pluck('id'))
            )
            ->join('rppm', 'rppm.id', '=', 'rpph.rppm_id')
            ->select('rppm.guru_id', 'rpph.status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('rppm.guru_id', 'rpph.status')
            ->get()
            ->groupBy('guru_id');

        $portoStats = Portofolio::whereIn('guru_id', $gurus->pluck('id'))
            ->whereHas('rpph.rppm', fn($q) =>
                $q->where('tahun_ajaran_id', $taAktif?->id)
            )
            ->select('guru_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('guru_id')
            ->pluck('jumlah', 'guru_id');

        // $aspekStats = RppmKegiatan::query()
        //     ->join('rppm', 'rppm.id', '=', 'rppm_kegiatan.rppm_id')
        //     ->join('kegiatan_aspek', 'kegiatan_aspek.kegiatan_id', '=', 'rppm_kegiatan.kegiatan_id')
        //     ->where('rppm.tahun_ajaran_id', $taAktif?->id)
        //     ->where('rppm.status', 'disetujui')
        //     ->whereIn('rppm.guru_id', $gurus->pluck('id'))
        //     ->select(
        //         'rppm.guru_id',
        //         'kegiatan_aspek.aspek_perkembangan_id',
        //         DB::raw('COUNT(*) as jumlah')
        //     )
        //     ->groupBy('rppm.guru_id', 'kegiatan_aspek.aspek_perkembangan_id')
        //     ->get()
        //     ->groupBy('guru_id');

        // $aspeks = AspekPerkembangan::all();

        $totalMinggu = Rppm::where('tahun_ajaran_id', $taAktif?->id)
            ->disetujui()
            ->max('minggu_ke') ?? 17;

        $guruData = $gurus->map(function ($guru) use (
            $rppmStats, $rpphStats, $portoStats, $totalMinggu
        ) {
            $rppmGuru  = $rppmStats[$guru->id] ?? collect();
            $rppmTotal = $rppmGuru->sum('jumlah');
            $rppmDisetujui  = $rppmGuru->where('status', 'disetujui')->sum('jumlah');
            $rppmPending    = $rppmGuru->where('status', 'pending')->sum('jumlah');
            // $rppmDraft      = $rppmGuru->where('status', 'draft')->sum('jumlah');
            // $rppmDikembalikan = $rppmGuru->where('status', 'dikembalikan')->sum('jumlah');

            $rpphGuru       = $rpphStats[$guru->id] ?? collect();
            $rpphTotal      = $rpphGuru->sum('jumlah');
            // $rpphDisetujui  = $rpphGuru->where('status', 'disetujui')->sum('jumlah');

            $portoTotal = $portoStats[$guru->id] ?? 0;

            // $aspekGuru = $aspekStats[$guru->id] ?? collect();
            // $aspekDetail = $aspeks->map(function ($aspek) use ($aspekGuru) {
            //     $jumlah = $aspekGuru
            //         ->where('aspek_perkembangan_id', $aspek->id)
            //         ->sum('jumlah');
            //     return [
            //         'id'     => $aspek->id,
            //         'emote'  => $aspek->emote,
            //         'name'   => $aspek->name,
            //         'warna'  => $aspek->warna,
            //         'jumlah' => $jumlah,
            //     ];
            // });

            $progress = $totalMinggu > 0
                ? min(100, round(($rppmDisetujui / $totalMinggu) * 100))
                : 0;

            return [
                'guru'              => $guru,
                'kelas'             => $guru->kelas?->name ?? '-',
                'rppm_total'        => $rppmTotal,
                'rppm_disetujui'    => $rppmDisetujui,
                'rppm_pending'      => $rppmPending,
                // 'rppm_draft'        => $rppmDraft,
                // 'rppm_dikembalikan' => $rppmDikembalikan,
                'rpph_total'        => $rpphTotal,
                // 'rpph_disetujui'    => $rpphDisetujui,
                'porto_total'       => $portoTotal,
                // 'aspek_detail'      => $aspekDetail,
                // 'aspek_nol'         => $aspekDetail->where('jumlah', 0)->count(),
                'progress'          => $progress,
            ];
        });

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