<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Portofolio;
use App\Models\Siswa;
use App\Models\AspekPerkembangan;
use App\Models\KomentarPortofolio;
use App\Models\TahunAjaran;
use App\Notifications\KomentarBaru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrtuPortoController extends Controller
{
    public function index(Request $request)
    {
        $ortu    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $siswas = Siswa::where('ortu_id', $ortu->id)
            ->with('kelas:id,name')
            ->orderBy('name')
            ->get(['id', 'name', 'jenis_kelamin', 'kelas_id']);

        if ($siswas->isEmpty()) {
            return view('pages.ortu_porto.index', [
                'siswas'      => $siswas,
                'siswaAktif'  => null,
                'portofolios' => collect(),
                'aspeks'      => collect(),
                'aspekData'   => collect(),
                'totalEntri'  => 0,
                'taAktif'     => $taAktif,
            ]);
        }

        $siswaAktifId = $request->input('siswa_id', $siswas->first()?->id);
        $siswaAktif   = $siswas->find($siswaAktifId);

        abort_if(!$siswaAktif, 403);

        $query = Portofolio::with([
            'aspeks:id,name,emote,warna',
            'kegiatan:id,name,foto_icon',
            'rpph.rppm.subTema:id,name,tema_id',
        ])
            ->withCount('komentars')
            ->where('siswa_id', $siswaAktifId);

        // Filter aspek
        if ($request->filled('aspek_id')) {
            $query->whereHas(
                'aspeks',
                fn($q) =>
                $q->where('aspek_perkembangan_id', $request->aspek_id)
            );
        }

        $portofolios = $query->latest()->paginate(9)->withQueryString();

        $aspeks = AspekPerkembangan::all();

        // Hitung frekuensi aspek dari SEMUA portofolio siswa ini (tanpa filter)
        $frekuensi = Portofolio::where('siswa_id', $siswaAktifId)
            ->join('portofolio_aspek', 'portofolio_aspek.portofolio_id', '=', 'portofolio.id')
            ->select('portofolio_aspek.aspek_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('portofolio_aspek.aspek_id')
            ->pluck('jumlah', 'aspek_id');

        $totalEntri = Portofolio::where('siswa_id', $siswaAktifId)->count();

        $aspekData = $aspeks->map(function ($aspek) use ($frekuensi, $totalEntri) {
            $jumlah     = $frekuensi[$aspek->id] ?? 0;
            $persentase = $totalEntri > 0
                ? round(($jumlah / $totalEntri) * 100)
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

        return view('pages.ortu_porto.index', compact(
            'siswas',
            'siswaAktif',
            'portofolios',
            'aspeks',
            'aspekData',
            'totalEntri',
            'taAktif',
        ));
    }

    public function show(int $id)
    {
        $porto = Portofolio::with([
            'siswa:id,ortu_id,name,jenis_kelamin',
            'kegiatan:id,name,foto_icon',
            'rpph.rppm.subTema:id,name,tema_id',
            'rpph.rppm.subTema.tema:id,name',
            'aspeks:id,name,emote,warna',
            'komentars.user:id,name,role',
        ])->findOrFail((int)$id);

        $user = Auth::user();
        $boleh = $porto->siswa->ortu_id === $user->id;

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

        $porto = Portofolio::find($portofolioId);
        if (Auth::user()->role === "ortu") {
            $porto->guru->notify(new KomentarBaru($komentar));
        }

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
