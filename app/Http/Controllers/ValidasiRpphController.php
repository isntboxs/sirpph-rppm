<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rpph;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Notifications\RpphDikembalikan;
use App\Notifications\RpphDisetujui;

class ValidasiRpphController extends Controller
{
    public function index(Request $request)
    {
        $taAktif = TahunAjaran::getActive();

        $pending = Rpph::with([
            'rppm.guru:id,name',
            'rppm.tahunAjaran:id,name',
            'rppm.subTema:id,name,tema_id',
            'rppm.subTema.tema:id,name',
            'rppm.rppmKegiatans' => function ($q) {
                $q->orderBy('urutan');
            },
            'rppm.rppmKegiatans.kegiatan.aspeks:id,name,emote,warna',
            'rppm.rppmKegiatans.kegiatan.bentukKegiatan:id,name',
        ])
            ->pendingValidasi()
            ->whereHas('rppm', function ($q) use ($taAktif) {
                $q->where('tahun_ajaran_id', $taAktif?->id)
                    ->where('status', 'disetujui');
            })
            ->latest()
            ->get();

        $query = Rpph::with([
            'rppm.guru:id,name',
            'rppm.subTema:id,name,tema_id',
            'rppm.subTema.tema:id,name',
        ])
            ->whereIn('status', ['disetujui', 'dikembalikan'])
            ->whereHas('rppm', function ($q) use ($taAktif) {
                $q->where('tahun_ajaran_id', $taAktif?->id);
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('guru_id')) {
            $query->whereHas('rppm', function ($q) use ($request) {
                $q->where('guru_id', $request->guru_id);
            });
        }

        $riwayat = $query->latest()->paginate(15)->withQueryString();

        $guruList = User::guru()->active()->get(['id', 'name']);

        return view('pages.validasi_rpph.index', compact(
            'pending',
            'riwayat',
            'taAktif',
            'guruList',
        ));
    }

    public function setujui(int $id)
    {
        $rpph = Rpph::findOrFail($id);

        if ($rpph->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'RPPH sudah diproses sebelumnya.',
            ], 422);
        }

        $rpph->update([
            'status'         => 'disetujui',
            'catatan_kepala' => null,
        ]);

        $rpph->rppm->guru->notify(new RpphDisetujui($rpph));

        return response()->json([
            'status'  => true,
            'message' => '✅ RPPH hari ' . $rpph->hari . ' berhasil disetujui.',
        ]);
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
            'penilaians.poins',
        ])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => [
                'id'       => $rpph->id,
                'hari'     => $rpph->hari,
                'tanggal'  => $rpph->tanggal_format,
                'kelas'    => $rpph->rppm->guru->kelas?->name ?? '-',
                'sub_tema' => $rpph->rppm->subTema->name,
                'sub_sub_tema' => $rpph->sub_sub_tema,
                'tema'     => $rpph->rppm->subTema->tema->name,
                'guru'     => $rpph->rppm->guru->name,
                'pembuka'  => $rpph->pembuka,
                'inti'     => $rpph->inti,
                'recalling'     => $rpph->recalling,
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
                'penilaians'  => $rpph->penilaians->map(fn($p) => [
                    'nama'  => $p->nama,
                    'poins' => $p->poins->pluck('poin'),
                ]),
            ],
        ]);
    }

    public function kembalikan(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'catatan' => 'required|string|max:1000',
        ], [
            'catatan.required' => 'Catatan wajib diisi.',
            'catatan.max'      => 'Catatan maksimal 1000 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $rpph = Rpph::findOrFail($id);

        if ($rpph->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'RPPH sudah diproses sebelumnya.',
            ], 422);
        }

        $rpph->update([
            'status'         => 'dikembalikan',
            'catatan_kepala' => $request->catatan,
        ]);

        $rpph->rppm->guru->notify(new RpphDikembalikan($rpph));

        return response()->json([
            'status'  => true,
            'message' => '↩️ RPPH dikembalikan ke guru.',
        ]);
    }
}
