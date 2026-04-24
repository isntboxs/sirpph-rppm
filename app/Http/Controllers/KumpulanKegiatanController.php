<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Kegiatan;
use App\Models\Tema;
use App\Models\BentukKegiatan;
use App\Models\AlatBahan;
use App\Models\AspekPerkembangan;

class KumpulanKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::with(['tema', 'bentukKegiatan', 'aspeks', 'alatBahans']);

        if ($request->filled('cari')) {
            $query->cari($request->cari);
        }

        if ($request->filled('tema_id')) {
            $query->tema($request->tema_id);
        }

        if ($request->filled('bentuk_id')) {
            $query->bentuk($request->bentuk_id);
        }

        if ($request->filled('aspek_id')) {
            $query->aspek($request->aspek_id);
        }

        if ($request->filled('status')) {
            $query->statusFilter($request->status);
        }

        // Paginate 12 per halaman, pertahankan query string di URL
        $kegiatans = $query->latest()->paginate(12)->withQueryString();

        // Data untuk dropdown filter
        $temas   = Tema::orderBy('semester')->get();
        $bentuk  = BentukKegiatan::orderBy('name')->get();
        $aspeks  = AspekPerkembangan::all();
        $alats   = AlatBahan::orderBy('name')->get();
        $status = [
            'pending'   => '⏳ Pending',
            'disetujui' => '✅ Disetujui',
            'ditolak'   => '❌ Ditolak',
        ];

        return view('pages.kumpulan_kegiatan.index', compact(
            'kegiatans',
            'temas',
            'bentuk',
            'aspeks',
            'alats',
            'status',
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:150',
            'tema_id'            => 'required|exists:tema,id',
            'bentuk_kegiatan_id' => 'required|exists:bentuk_kegiatan,id',
            'deskripsi'          => 'nullable|string',
            'foto_icon'          => 'nullable|string|max:10',
            'aspek_ids'          => 'required|array|min:1',
            'aspek_ids.*'        => 'exists:aspek_perkembangan,id',
            'alat_ids'           => 'nullable|array',
            'alat_ids.*'         => 'exists:alat_bahan,id',
        ], [
            'name.required'               => 'Nama kegiatan wajib diisi.',
            'tema_id.required'            => 'Tema wajib dipilih.',
            'bentuk_kegiatan_id.required' => 'Bentuk kegiatan wajib dipilih.',
            'aspek_ids.required'          => 'Minimal 1 aspek perkembangan wajib dipilih.',
            'aspek_ids.min'               => 'Minimal 1 aspek perkembangan wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Buat kegiatan — status default 'pending', menunggu validasi kepala
        $kegiatan = Kegiatan::create([
            'name'               => $request->name,
            'tema_id'            => $request->tema_id,
            'bentuk_kegiatan_id' => $request->bentuk_kegiatan_id,
            'deskripsi'          => $request->deskripsi,
            'foto_icon'          => $request->foto_icon ?? '🎨',
            'status'             => 'pending',
            'diusulkan_oleh'     => Auth::id(),
        ]);

        // Simpan relasi aspek (pivot)
        $kegiatan->aspeks()->attach($request->aspek_ids);

        // Simpan relasi alat (pivot) jika ada
        if ($request->filled('alat_ids')) {
            $kegiatan->alatBahans()->attach($request->alat_ids);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Kegiatan berhasil diusulkan dan menunggu persetujuan Kepala Sekolah.',
        ]);
    }
}
