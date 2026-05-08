<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AspekPerkembangan;
use App\Models\Kelas;
use App\Models\RppmKegiatan;
use App\Models\TahunAjaran;
use App\Models\Rppm;

class AnalisisAspekController extends Controller
{
    public function index()
    {
        $guru    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $aspeks = AspekPerkembangan::all();
        $kelas = Kelas::where('guru_id', $guru->id)->select('name')->first();

        $frekuensiAspek = RppmKegiatan::query()
            ->join('rppm', 'rppm.id', '=', 'rppm_kegiatan.rppm_id')
            ->join('kegiatan_aspek', 'kegiatan_aspek.kegiatan_id', '=', 'rppm_kegiatan.kegiatan_id')
            ->where('rppm.guru_id', $guru->id)
            ->where('rppm.status', 'disetujui')
            ->where('rppm.tahun_ajaran_id', $taAktif?->id)
            ->select('kegiatan_aspek.aspek_perkembangan_id')
            ->selectRaw('COUNT(*) as jumlah')
            ->groupBy('kegiatan_aspek.aspek_perkembangan_id')
            ->pluck('jumlah', 'aspek_perkembangan_id');

        $totalKegiatan = RppmKegiatan::query()
            ->join('rppm', 'rppm.id', '=', 'rppm_kegiatan.rppm_id')
            ->where('rppm.guru_id', $guru->id)
            ->where('rppm.status', 'disetujui')
            ->where('rppm.tahun_ajaran_id', $taAktif?->id)
            ->count();

        $aspekData = $aspeks->map(function ($aspek) use ($frekuensiAspek, $totalKegiatan) {
            $jumlah     = $frekuensiAspek[$aspek->id] ?? 0;
            $persentase = $totalKegiatan > 0
                ? round(($jumlah / $totalKegiatan) * 100)
                : 0;

            return [
                'id'         => $aspek->id,
                'name'       => $aspek->name,
                'emote'      => $aspek->emote,
                'warna'      => $aspek->warna,
                'jumlah'     => $jumlah,
                'persentase' => $persentase,
            ];
        })->sortByDesc('jumlah')->values();

        $ringkasan = [
            'rppm_disetujui'  => Rppm::olehGuru($guru->id)
                                     ->disetujui()
                                     ->where('tahun_ajaran_id', $taAktif?->id)
                                     ->count(),
        ];

        return view('pages.analisis_aspek.index', compact(
            'aspekData',
            'kelas',
            'ringkasan',
            'taAktif',
            'totalKegiatan',
        ));
    }
}