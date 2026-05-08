<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rpph;
use App\Models\Siswa;
use App\Models\TahunAjaran;

class OrtuRpphController extends Controller
{
    public function index(Request $request)
    {
        $ortu    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $siswas = Siswa::where('ortu_id', $ortu->id)
            ->with('kelas:id,name')
            ->get(['id', 'name', 'jenis_kelamin', 'kelas_id']);

        if ($siswas->isEmpty()) {
            return view('pages.ortu_rpph.index', [
                'siswas'  => $siswas,
                'rpphs'   => collect(),
                'taAktif' => $taAktif,
            ]);
        }

        $kelasIds = $siswas->pluck('kelas_id')->unique()->filter();

        $query = Rpph::with([
            'rppm.guru:id,name',
            'rppm.subTema:id,name,tema_id',
            'rppm.subTema.tema:id,name',
            'rppm.rppmKegiatans' => fn($q) => $q->orderBy('urutan'),
            'rppm.rppmKegiatans.kegiatan.aspeks:id,name,emote,warna',
            'rppm.rppmKegiatans.kegiatan.bentukKegiatan:id,name',
        ])
            ->disetujui()
            ->whereHas(
                'rppm',
                fn($q) =>
                $q->where('tahun_ajaran_id', $taAktif?->id)
                    ->where('status', 'disetujui')
                    ->whereHas(
                        'guru.kelas',
                        fn($q2) =>
                        $q2->whereIn('id', $kelasIds)
                    )
            )
            ->latest();

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        $rpphs = $query->paginate(10)->withQueryString();

        return view('pages.ortu_rpph.index', compact(
            'siswas',
            'rpphs',
            'taAktif',
        ));
    }

    public function show(int $id)
    {
        $rpph = Rpph::with([
            'rppm.guru:id,name',
            'rppm.subTema:id,name,tema_id',
            'rppm.subTema.tema:id,name',
            'rppm.rppmKegiatans' => function ($q) use ($id) {
                $rpph = Rpph::find($id);
                $q->where('hari', $rpph?->hari)->orderBy('urutan');
            },
            'rppm.rppmKegiatans.kegiatan.aspeks:id,name,emote,warna',
            'rppm.rppmKegiatans.kegiatan.bentukKegiatan:id,name',
            'rppm.guru.kelas:guru_id,name',
        ])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => [
                'id'       => $rpph->id,
                'hari'     => $rpph->hari,
                'tanggal'  => $rpph->tanggal_format,
                'kelas'    => $rpph->rppm->guru->kelas?->name ?? '-',
                'sub_tema' => $rpph->rppm->subTema->name,
                'tema'     => $rpph->rppm->subTema->tema->name,
                'guru'     => $rpph->rppm->guru->name,
                'pembuka'  => $rpph->pembuka,
                'inti'     => $rpph->inti,
                'penutup'  => $rpph->penutup,
                'catatan'  => $rpph->catatan,
                'status'   => $rpph->status,
                'kegiatan' => $rpph->rppm->rppmKegiatans->map(fn($rk) => [
                    'icon'   => $rk->kegiatan->foto_icon,
                    'name'   => $rk->kegiatan->name,
                    'bentuk' => $rk->kegiatan->bentukKegiatan->name,
                    'aspeks' => $rk->kegiatan->aspeks->map(fn($a) => [
                        'emote' => $a->emote,
                        'name'  => $a->name,
                        'warna' => $a->warna,
                    ]),
                ]),
            ],
        ]);
    }
}
