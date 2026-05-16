<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Rpph;
use App\Models\RpphPenilaian;
use App\Models\RpphPenilaianPoin;
use App\Models\Rppm;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Notifications\RpphDiajukan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            'rpphs.penilaians',
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

        // $validator = Validator::make($request->all(), [
        //     'pembuka'    => 'nullable|string',
        //     'inti'       => 'nullable|string',
        //     'penutup'    => 'nullable|string',
        // ]);

        $validator = Validator::make($request->all(), [
            'tanggal'       => 'required|date',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'sub_sub_tema'  => 'nullable|string|max:150',
            'pembuka'       => 'nullable|string',
            'inti'          => 'nullable|string',
            'recalling'     => 'nullable|string',
            'penutup'       => 'nullable|string',

            'penilaians'              => 'nullable|array',
            'penilaians.*.nama'       => 'required|string|max:100',
            'penilaians.*.poins'      => 'nullable|array',
            'penilaians.*.poins.*'    => 'nullable|string',
        ], [
            'tanggal.required' => 'Tanggal pelaksanaan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        if ($rpph->rppm->bulan) {
            $tanggal = Carbon::parse($request->tanggal);

            if ($tanggal->month !== $rpph->rppm->bulan || $tanggal->year !== $rpph->rppm->tahun) {
                return response()->json([
                    'status' => false,
                    'errors' => [
                        'tanggal' => [
                            'Tanggal harus berada di bulan '
                                . $rpph->rppm->bulan_nama . ' '
                                . $rpph->rppm->tahun . '.'
                        ]
                    ],
                ], 422);
            }
        }

        $tanggalBentrok = Rpph::where('rppm_id', $rpph->rppm_id)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $rpph->id)
            ->exists();

        if ($tanggalBentrok) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'tanggal' => ['Tanggal ini sudah dipakai oleh RPPH hari lain di minggu yang sama.']
                ],
            ], 422);
        }

        // $rpph->update($request->only(['pembuka', 'inti', 'penutup']));

        DB::transaction(function () use ($request, $rpph) {
            $rpph->update($request->only([
                'tanggal',
                'kelas_id',
                'sub_sub_tema',
                'pembuka',
                'inti',
                'recalling',
                'penutup',
            ]));

            $rpph->penilaians()->delete();

            if ($request->filled('penilaians')) {
                foreach ($request->penilaians as $urutan => $p) {
                    if (empty(trim($p['nama']))) continue;

                    $penilaian = RpphPenilaian::create([
                        'rpph_id' => $rpph->id,
                        'nama'    => $p['nama'],
                        'urutan'  => $urutan + 1,
                    ]);

                    if (!empty($p['poins'])) {
                        foreach ($p['poins'] as $urutanPoin => $poin) {
                            if (empty(trim($poin))) continue;
                            RpphPenilaianPoin::create([
                                'penilaian_id' => $penilaian->id,
                                'poin'         => $poin,
                                'urutan'       => $urutanPoin + 1,
                            ]);
                        }
                    }
                }
            }
        });

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

        if (!$rpph->tanggal) {
            return response()->json([
                'status'  => false,
                'message' => 'RPPH harus memiliki tanggal pelaksanaan sebelum diajukan.',
            ], 422);
        }

        $rpph->update(['status' => 'pending', 'catatan_kepala' => null]);

        User::kepalaSekolah()->active()->each(fn($k) => $k->notify(new RpphDiajukan($rpph)));

        return response()->json([
            'status'  => true,
            'message' => '📤 RPPH hari ' . $rpph->hari . ' berhasil diajukan.',
        ]);
    }

    public function tanggalTerpakai(string $rppmId)
    {
        $rppm = Rppm::findOrFail((int) $rppmId);
        abort_if($rppm->guru_id !== Auth::id(), 403);

        $terpakai = Rpph::where('rppm_id', $rppmId)
            ->whereNotNull('tanggal')
            ->pluck('tanggal', 'hari')
            ->map(fn($t) => Carbon::parse($t)->format('Y-m-d'));

        return response()->json([
            'status'          => true,
            'bulan'           => $rppm->bulan,
            'tahun'           => $rppm->tahun,
            'bulan_nama'      => $rppm->bulan_nama,
            'tanggal_terpakai' => $terpakai->values(),
            'min_date'        => Carbon::create($rppm->tahun, $rppm->bulan, 1)->format('Y-m-d'),
            'max_date'        => Carbon::create($rppm->tahun, $rppm->bulan, 1)->endOfMonth()->format('Y-m-d'),
        ]);
    }

    public function getPenilaian(string $id)
    {
        $rpph = Rpph::with('penilaians.poins')->findOrFail((int) $id);
        abort_if($rpph->rppm->guru_id !== Auth::id(), 403);

        return response()->json([
            'status' => true,
            'data'   => $rpph->penilaians->map(fn($p) => [
                'id'    => $p->id,
                'nama'  => $p->nama,
                'poins' => $p->poins->map(fn($poin) => [
                    'id'   => $poin->id,
                    'poin' => $poin->poin,
                ]),
            ]),
        ]);
    }
}
