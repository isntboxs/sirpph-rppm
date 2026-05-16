<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kegiatan;
use App\Models\TahunAjaran;
use App\Models\Tema;
use App\Models\AspekPerkembangan;
use App\Notifications\KegiatanDisetujui;
use App\Notifications\KegiatanDitolak;

class ValidasiKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $taAktif = TahunAjaran::getActive();

        $pending = Kegiatan::with([
            'tema',
            'bentukKegiatan',
            'aspeks',
            'alatBahans',
            'diusulkanOleh:id,name',
        ])
            ->pending()
            ->latest()
            ->get();

        $query = Kegiatan::withJumlahTahun()
            ->with([
                'tema:id,name',
                'bentukKegiatan:id,name',
                'aspeks:id,name,emote,warna',
            ])
            ->disetujui();

        // Filter
        if ($request->filled('cari')) {
            $query->cari($request->cari);
        }
        if ($request->filled('tema_id')) {
            $query->tema((int) $request->tema_id);
        }
        if ($request->filled('status_kunci')) {
            match ($request->status_kunci) {
                'terkunci' => $query->terkunci(),
                'aktif'    => $query->belumTerkunci(),
                default    => null,
            };
        }

        $kegiatans = $query
            ->orderByRaw('jumlah_tahun_dipakai DESC')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // $kegiatanTerkunci = Kegiatan::withJumlahTahun()
        //     ->with([
        //         'tema:id,name',
        //         'bentukKegiatan:id,name',
        //         'aspeks:id,name,emote,warna',
        //     ])
        //     ->disetujui()
        //     ->terkunci()
        //     ->orderBy('name')
        //     ->get();

        // // Ambil tahun ajaran yang dipakai per kegiatan dalam 1 query
        // $tahunPerKegiatan = \App\Models\RppmKegiatan::query()
        //     ->join('rppm', 'rppm.id', '=', 'rppm_kegiatan.rppm_id')
        //     ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'rppm.tahun_ajaran_id')
        //     ->where('rppm.status', 'disetujui')
        //     ->whereIn('rppm_kegiatan.kegiatan_id', $kegiatanTerkunci->pluck('id'))
        //     ->select('rppm_kegiatan.kegiatan_id', 'tahun_ajaran.name')
        //     ->distinct()
        //     ->orderBy('tahun_ajaran.name')
        //     ->get()
        //     ->groupBy('kegiatan_id')
        //     ->map(fn($rows) => $rows->pluck('name'));


        $temas  = Tema::orderBy('semester')->get(['id', 'name', 'semester']);
        $aspeks = AspekPerkembangan::all();

        return view('pages.validasi_kegiatan.index', compact(
            'pending',
            'kegiatans',
            // 'kegiatanTerkunci',
            // 'tahunPerKegiatan',
            'temas',
            'aspeks',
            'taAktif',
        ));
    }

    public function setujui(int $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'Kegiatan sudah diproses sebelumnya.',
            ], 422);
        }

        $kegiatan->update([
            'status'         => 'disetujui',
            'catatan_kepala' => null,
        ]);

        $kegiatan->diusulkanOleh->notify(new KegiatanDisetujui($kegiatan));

        return response()->json([
            'status'  => true,
            'message' => '✅ Kegiatan disetujui dan masuk ke kumpulan kegiatan.',
        ]);
    }

    public function tolak(Request $request, int $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'catatan' => 'required|string|max:500',
        // ], [
        //     'catatan.required' => 'Catatan penolakan wajib diisi.',
        //     'catatan.max'      => 'Catatan maksimal 500 karakter.',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'errors' => $validator->errors(),
        //     ], 422);
        // }

        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'Kegiatan sudah diproses sebelumnya.',
            ], 422);
        }

        $kegiatan->update([
            'status'         => 'ditolak',
            'catatan_kepala' => $request->catatan,
        ]);

        $kegiatan->diusulkanOleh->notify(new KegiatanDitolak($kegiatan));

        return response()->json([
            'status'  => true,
            'message' => '↩️ Kegiatan dikembalikan ke guru.',
        ]);
    }

    public function extend(Request $request, string $id)
    {
        $kegiatan = Kegiatan::findOrFail((int) $id);

        $validator = Validator::make($request->all(), [
            'tambah_semester' => 'required|integer|min:1|max:5',
        ], [
            'tambah_semester.required' => 'Jumlah semester wajib diisi.',
            'tambah_semester.min'      => 'Minimal tambah 1 semester.',
            'tambah_semester.max'      => 'Maksimal tambah 5 semester sekaligus.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!$kegiatan->isTerkunci()) {
            return response()->json([
                'status'  => false,
                'message' => 'Kegiatan ini belum terkunci, tidak perlu di-extend.',
            ], 422);
        }

        $maks_baru = $kegiatan->maks_pemakaian + (int) $request->tambah_semester;

        $kegiatan->update(['maks_pemakaian' => $maks_baru]);

        return response()->json([
            'status'  => true,
            'message' => '✅ Kegiatan berhasil di-extend. Batas pemakaian sekarang '
                . $maks_baru . ' semester.',
            'data'    => [
                'maks_pemakaian'      => $maks_baru,
                'jumlah_tahun_dipakai' => $kegiatan->jumlah_tahun_dipakai,
                'label_pemakaian'     => $kegiatan->getLabelPemakaianAttribute(),
                'presentase'          => $kegiatan->presentase_pemakaian,
                'warna'               => $kegiatan->warna_progress,
                'is_terkunci'         => $kegiatan->isTerkunci(),
            ],
        ]);
    }
}
