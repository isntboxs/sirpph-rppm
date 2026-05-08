<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rppm;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\Tema;

class OrtuRppmController extends Controller
{
    public function index(Request $request)
    {
        $ortu    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $siswas = Siswa::where('ortu_id', $ortu->id)
            ->with('kelas:id,name')
            ->get(['id', 'name', 'jenis_kelamin', 'kelas_id']);

        if ($siswas->isEmpty()) {
            return view('pages.ortu_rppm.index', [
                'siswas'  => $siswas,
                'rppms'   => collect(),
                'taAktif' => $taAktif,
            ]);
        }

        $kelasIds = $siswas->pluck('kelas_id')->unique()->filter();

        $query = Rppm::with([
                'guru:id,name',
                'subTema:id,name,tema_id',
                'subTema.tema:id,name',
                'tahunAjaran:id,name,semester',
                'rppmKegiatans.kegiatan.aspeks:id,name,emote,warna',
                'rppmKegiatans.kegiatan.bentukKegiatan:id,name',
                'rppmKegiatans.kegiatan.alatBahans:id,name',
            ])
            ->disetujui()
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->whereHas('guru.kelas', fn($q) =>
                $q->whereIn('id', $kelasIds)
            )
            ->orderBy('minggu_ke');

        if ($request->filled('tema_id')) {
            $query->whereHas('subTema', fn($q) =>
                $q->where('tema_id', $request->tema_id)
            );
        }

        $rppms = $query->paginate(10)->withQueryString();

        $temas = Tema::orderBy('semester')->get(['id', 'name']);

        return view('pages.ortu_rppm.index', compact(
            'siswas',
            'rppms',
            'taAktif',
            'temas',
        ));
    }

    public function show(string $id)
    {
        $ortu   = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $kelasIds = Siswa::where('ortu_id', $ortu->id)
            ->pluck('kelas_id')
            ->filter();

        $rppm = Rppm::with([
                'guru:id,name',
                'subTema:id,name,tema_id',
                'subTema.tema:id,name',
                'tahunAjaran:id,name,semester',
                'rppmKegiatans' => fn($q) => $q->orderBy('hari')->orderBy('urutan'),
                'rppmKegiatans.kegiatan.aspeks:id,name,emote,warna',
                'rppmKegiatans.kegiatan.bentukKegiatan:id,name',
                'rppmKegiatans.kegiatan.alatBahans:id,name',
            ])
            ->disetujui()
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->whereHas('guru.kelas', fn($q) =>
                $q->whereIn('id', $kelasIds)
            )
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => [
                'minggu_ke'   => $rppm->minggu_ke,
                'tema'        => $rppm->subTema->tema->name,
                'sub_tema'    => $rppm->subTema->name,
                'guru'        => $rppm->guru->name,
                'ta'          => $rppm->tahunAjaran->name,
                'model'       => $rppm->model_pembelajaran ?? '-',
                'tujuan'      => $rppm->tujuan ?? '-',
                'capaian'     => $rppm->capaian ?? '-',
                'kegiatan'    => collect(['Senin','Selasa','Rabu','Kamis','Jumat'])
                    ->mapWithKeys(fn($hari) => [
                        $hari => $rppm->rppmKegiatans
                            ->where('hari', $hari)
                            ->map(fn($rk) => [
                                'icon'   => $rk->kegiatan->foto_icon,
                                'name'   => $rk->kegiatan->name,
                                'bentuk' => $rk->kegiatan->bentukKegiatan->name,
                                'alat'   => $rk->kegiatan->alatBahans->pluck('name')->join(', '),
                                'aspeks' => $rk->kegiatan->aspeks->map(fn($a) => [
                                    'emote' => $a->emote,
                                    'name'  => $a->name,
                                    'warna' => $a->warna,
                                ]),
                            ]),
                    ]),
            ],
        ]);
    }
}