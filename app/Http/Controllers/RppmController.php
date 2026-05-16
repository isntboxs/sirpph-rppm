<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Rppm;
use App\Models\RppmKegiatan;
use App\Models\Rpph;
use App\Models\Kegiatan;
use App\Models\Tema;
use App\Models\TahunAjaran;
use App\Models\AspekPerkembangan;
use App\Models\Prosem;
use App\Models\User;
use App\Notifications\RppmDiajukan;

class RppmController extends Controller
{
    public function index()
    {
        $guru    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $rppms = Rppm::with(['subTema.tema', 'tahunAjaran', 'rppmKegiatans.kegiatan.aspeks'])
            ->olehGuru($guru->id)
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->latest()
            ->get();

        $prosemValid = Prosem::with(['tema', 'subTema'])
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->valid()
            ->orderBy('minggu_ke')
            ->get();

        $mingguSudahAda = $rppms->pluck('minggu_ke')->toArray();

        $modelList   = [
            'Berbasis Proyek',
            'Kelompok dengan Sudut',
            'Sentra',
            'Area',
            'STEM',
        ];

        return view('pages.rppm.index', compact(
            'rppms',
            'prosemValid',
            'mingguSudahAda',
            'taAktif',
            'modelList'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'minggu_ke'          => 'required|integer|min:1|max:34',
            'bulan'              => 'required|integer|min:1|max:12',
            'tahun'              => 'required|integer',
            'model_pembelajaran' => 'nullable|string|max:100',
            'tujuan'             => 'nullable|string',
            'capaian'            => 'nullable|string',
        ], [
            'minggu_ke.required' => 'Minggu ke wajib diisi.',
            'bulan.required'     => 'Bulan pelaksanaan wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $taAktif = TahunAjaran::getActive();
        $prosem = \App\Models\Prosem::with(['subTema'])
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->where('minggu_ke', $request->minggu_ke)
            ->valid()
            ->first();

        if (!$prosem) {
            return response()->json([
                'status' => false,
                'errors' => ['minggu_ke' => ['PROSEM untuk minggu ini belum divalidasi atau tidak ditemukan.']],
            ], 422);
        }

        $sudahAda = Rppm::where('guru_id', Auth::id())
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->where('minggu_ke', $request->minggu_ke)
            ->exists();

        if ($sudahAda) {
            return response()->json([
                'status' => false,
                'errors' => ['minggu_ke' => ['RPPM untuk minggu ke-' . $request->minggu_ke . ' sudah pernah dibuat.']],
            ], 422);
        }

        $rppm = Rppm::create([
            'guru_id'            => Auth::id(),
            'tahun_ajaran_id'    => $taAktif->id,
            'sub_tema_id'        => $prosem->sub_tema_id,
            'minggu_ke'          => $request->minggu_ke,
            'bulan'              => $request->bulan,
            'tahun'              => $request->tahun,
            'model_pembelajaran' => $request->model_pembelajaran,
            'tujuan'             => $request->tujuan,
            'capaian'            => $request->capaian,
            'status'             => 'draft',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'RPPM berhasil dibuat sebagai draft.',
            'rppm_id' => $rppm->id,
            'tema'    => $prosem->subTema->tema->name ?? '-',
            'sub_tema' => $prosem->subTema->name ?? '-',
        ]);
    }

    public function show(int $id)
    {
        $rppm = Rppm::with([
            'subTema.tema',
            'tahunAjaran',
            'guru',
            'rppmKegiatans.kegiatan.aspeks',
            'rppmKegiatans.kegiatan.bentukKegiatan',
            'rppmKegiatans.kegiatan.alatBahans',
        ])->findOrFail($id);

        abort_if($rppm->guru_id !== Auth::id(), 403);

        $kegiatanTersedia = Kegiatan::with(['aspeks', 'bentukKegiatan'])
            ->disetujui()
            ->belumTerkunci()
            ->get();

        $aspeks = AspekPerkembangan::all();

        return view('pages.rppm.show', compact('rppm', 'kegiatanTersedia', 'aspeks'));
    }

    public function tambahKegiatan(Request $request, int $rppmId)
    {
        $rppm = Rppm::findOrFail($rppmId);

        abort_if($rppm->guru_id !== Auth::id(), 403);
        abort_if(!in_array($rppm->status, ['draft', 'dikembalikan']), 422);

        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);

        if ($kegiatan->isTerkunci()) {
            return response()->json([
                'status'  => false,
                'message' => 'Kegiatan ini sudah terkunci karena dipakai di 3 tahun ajaran berbeda.',
            ], 422);
        }

        $sudahAda = RppmKegiatan::where('rppm_id', $rppmId)
            ->where('kegiatan_id', $request->kegiatan_id)
            ->where('hari', $request->hari)
            ->exists();

        if ($sudahAda) {
            return response()->json([
                'status'  => false,
                'message' => 'Kegiatan ini sudah ada di hari ' . $request->hari . '.',
            ], 422);
        }

        $urutan = RppmKegiatan::where('rppm_id', $rppmId)
            ->where('hari', $request->hari)
            ->count() + 1;

        RppmKegiatan::create([
            'rppm_id'     => $rppmId,
            'kegiatan_id' => $request->kegiatan_id,
            'hari'        => $request->hari,
            'urutan'      => $urutan,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Kegiatan berhasil ditambahkan ke hari ' . $request->hari . '.',
        ]);
    }

    public function hapusKegiatan(int $rppmKegiatanId)
    {
        $rk   = RppmKegiatan::with('rppm')->findOrFail($rppmKegiatanId);
        abort_if($rk->rppm->guru_id !== Auth::id(), 403);
        abort_if(!in_array($rk->rppm->status, ['draft', 'dikembalikan']), 422);

        $rk->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Kegiatan berhasil dihapus dari RPPM.',
        ]);
    }

    public function ajukan(int $id)
    {
        $rppm = Rppm::with('rppmKegiatans')->findOrFail($id);
        abort_if($rppm->guru_id !== Auth::id(), 403);

        if ($rppm->rppmKegiatans->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'RPPM harus memiliki minimal 1 kegiatan sebelum diajukan.',
            ], 422);
        }

        $rppm->update(['status' => 'pending', 'catatan_kepala' => null]);

        User::KepalaSekolah()->active()->each(function ($kepala) use ($rppm) {
            $kepala->notify(new RppmDiajukan($rppm));
        });

        return response()->json([
            'status'  => true,
            'message' => '📤 RPPM berhasil diajukan ke Kepala Sekolah.',
        ]);
    }

    public function generateRpph(int $id)
    {
        $rppm = Rppm::with('rppmKegiatans')->findOrFail($id);
        abort_if($rppm->guru_id !== Auth::id(), 403);
        abort_if($rppm->status !== 'disetujui', 422);

        $hariAda = $rppm->rppmKegiatans->pluck('hari')->unique()->values();

        DB::transaction(function () use ($rppm, $hariAda) {
            foreach ($hariAda as $hari) {
                Rpph::firstOrCreate(
                    ['rppm_id' => $rppm->id, 'hari' => $hari],
                    ['status' => 'draft']
                );
            }
        });

        return response()->json([
            'status'  => true,
            'message' => '⚡ RPPH berhasil di-generate untuk ' . $hariAda->count() . ' hari.',
        ]);
    }

    public function destroy(string $id)
    {
        $rppm = Rppm::with('rpphs')->findOrFail((int) $id);

        abort_if($rppm->guru_id !== Auth::id(), 403);

        if ($rppm->status === 'disetujui') {
            return response()->json([
                'status'  => false,
                'message' => 'RPPM yang sudah disetujui tidak bisa dihapus.',
            ], 422);
        }

        $rppm->delete();

        return response()->json([
            'status'  => true,
            'message' => '🗑️ RPPM berhasil dihapus. Kamu bisa membuat RPPM baru untuk minggu tersebut.',
        ]);
    }
}
