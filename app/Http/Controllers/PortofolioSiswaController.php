<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Portofolio;
use App\Models\KomentarPortofolio;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\AspekPerkembangan;
use App\Models\Rpph;
use App\Models\RppmKegiatan;
use App\Notifications\KomentarBaru;
use App\Notifications\PortofolioBaru;

class PortofolioSiswaController extends Controller
{
    public function index(Request $request)
    {
        $guru  = Auth::user();

        $kelas = Kelas::where('guru_id', $guru->id)->first();

        if (!$kelas) {
            return view('pages.portofolio_siswa.index', [
                'kelas'          => null,
                'siswas'         => collect(),
                'portofolios'    => collect(),
                'siswaAktif'     => null,
                'aspeks'         => collect(),
                'kegiatanList'   => collect(),
                'rpphList'       => collect(),
            ]);
        }

        $siswas = Siswa::where('kelas_id', $kelas->id)
            ->orderBy('name')
            ->get(['id', 'name', 'jenis_kelamin']);

        $siswaAktifId = $request->input('siswa_id', $siswas->first()?->id);
        $siswaAktif   = $siswas->find($siswaAktifId);

        $query = Portofolio::with([
            'aspeks:id,name,emote,warna',
            'kegiatan:id,name,foto_icon',
            'komentars',
        ])
            ->siswa($siswaAktifId)
            ->olehGuru($guru->id);

        if ($request->filled('aspek_id')) {
            $query->aspek((int) $request->aspek_id);
        }

        $portofolios = $query->latest()->paginate(9)->withQueryString();

        $aspeks = AspekPerkembangan::all();

        $rpphList = Rpph::with([
            'rppm.subTema:id,name,tema_id',
            'rppm.subTema.tema:id,name',
            'rppm.rppmKegiatans.kegiatan:id,name,foto_icon',
        ])
            ->disetujui()
            ->whereHas('rppm', fn($q) => $q->where('guru_id', $guru->id))
            ->latest()
            ->take(10)
            ->get();

        return view('pages.portofolio_siswa.index', compact(
            'kelas',
            'siswas',
            'siswaAktif',
            'portofolios',
            'aspeks',
            'rpphList',
        ));
    }

    public function show(int $id)
    {
        $porto = Portofolio::with([
            'siswa:id,name,jenis_kelamin',
            'kegiatan:id,name,foto_icon',
            'rpph.rppm.subTema:id,name,tema_id',
            'rpph.rppm.subTema.tema:id,name',
            'aspeks:id,name,emote,warna',
            'komentars.user:id,name,role',
        ])->findOrFail((int)$id);

        $user = Auth::user();
        $boleh = $porto->guru_id === $user->id;

        abort_if(!$boleh, 403);

        return response()->json([
            'status' => true,
            'data'   => [
                'id'          => $porto->id,
                'foto_icon'   => $porto->foto_icon,
                'nama_siswa'  => $porto->siswa->name,
                'jk'          => $porto->siswa->jenis_kelamin,
                'tanggal'     => $porto->tanggal_format,
                'tanggal_raw' => $porto->created_at->format('Y-m-d'),
                'kegiatan'    => $porto->kegiatan?->name,
                'sub_tema'    => $porto->rpph?->rppm->subTema->name,
                'catatan'     => $porto->catatan,
                'aspeks'      => $porto->aspeks->map(fn($a) => [
                    'emote' => $a->emote,
                    'name'  => $a->name,
                    'warna' => $a->warna,
                ]),
                'komentars'   => $porto->komentars->map(fn($k) => [
                    'id'     => $k->id,
                    'author' => $k->user->name,
                    'role'   => $k->user->role,
                    'teks'   => $k->komentar,
                    'waktu'  => $k->created_at->format('Y-m-d H:i'),
                ]),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id'    => 'required|exists:siswa,id',
            'foto_icon'   => 'nullable|string|max:10',
            'catatan'     => 'required|string|max:1000',
            'aspek_ids'   => 'required|array|min:1',
            'aspek_ids.*' => 'exists:aspek_perkembangan,id',
            'rpph_id'     => 'nullable|exists:rpph,id',
            'kegiatan_id' => 'nullable|exists:kegiatan,id',
        ], [
            'siswa_id.required'  => 'Siswa wajib dipilih.',
            'catatan.required'   => 'Catatan observasi wajib diisi.',
            'aspek_ids.required' => 'Minimal 1 aspek wajib dipilih.',
            'aspek_ids.min'      => 'Minimal 1 aspek wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->filled('rpph_id') && $request->filled('kegiatan_id')) {
            $rpph = Rpph::findOrFail($request->rpph_id);

            $kegiatanValid = RppmKegiatan::where('rppm_id', $rpph->rppm_id)
                ->where('hari', $rpph->hari)
                ->where('kegiatan_id', $request->kegiatan_id)
                ->exists();

            if (!$kegiatanValid) {
                return response()->json([
                    'status' => false,
                    'errors' => [
                        'kegiatan_id' => ['Kegiatan tidak sesuai dengan RPPH yang dipilih.']
                    ],
                ], 422);
            }
        }

        $portofolio = Portofolio::create([
            'siswa_id'    => $request->siswa_id,
            'guru_id'     => Auth::id(),
            'rpph_id'     => $request->rpph_id,
            'kegiatan_id' => $request->kegiatan_id,
            'foto_icon'   => $request->foto_icon ?? '📸',
            'catatan'     => $request->catatan,
        ]);

        $portofolio->aspeks()->attach($request->aspek_ids);

        if ($portofolio->siswa->ortu_id) {
            $portofolio->siswa->ortu->notify(new PortofolioBaru($portofolio));
        }

        return response()->json([
            'status'  => true,
            'message' => '📸 Portofolio berhasil ditambahkan.',
        ]);
    }

    public function destroy(int $id)
    {
        $porto = Portofolio::findOrFail($id);
        abort_if($porto->guru_id !== Auth::id(), 403);

        $porto->delete();

        return response()->json([
            'status'  => true,
            'message' => '🗑️ Entri portofolio dihapus.',
        ]);
    }

    public function simpanKomentar(Request $request, int $portofolioId)
    {
        $validator = Validator::make($request->all(), [
            'komentar' => 'required|string|max:500',
        ], [
            'komentar.required' => 'Komentar tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $komentar = KomentarPortofolio::create([
            'portofolio_id' => $portofolioId,
            'user_id'       => Auth::id(),
            'komentar'      => $request->komentar,
        ]);

        $komentar->load('user:id,name,role');

        return response()->json([
            'status'  => true,
            'message' => 'Komentar berhasil disimpan.',
            'data'    => [
                'id'          => $komentar->id,
                'komentar'    => $komentar->komentar,
                'author'      => $komentar->user->name,
                'role'        => $komentar->user->role,
                'waktu'       => $komentar->waktu_format,
            ],
        ]);
    }
}
