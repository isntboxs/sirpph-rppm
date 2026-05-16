<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataSekolah;
use App\Models\Kegiatan;
use App\Models\KomentarPortofolio;
use App\Models\Portofolio;
use App\Models\Rpph;
use App\Models\Rppm;
use App\Models\RppmKegiatan;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        return match (Auth::user()->role) {
            'admin'  => $this->berandaAdmin(),
            'kepala' => $this->berandaKepala(),
            'guru'   => $this->berandaGuru(),
            'ortu'   => $this->berandaOrtu(),
            default  => redirect()->route('login'),
        };
    }

    private function berandaAdmin()
    {
        $taAktif = TahunAjaran::getActive();
        $dataSekolah = DataSekolah::getData();

        $stats = [
            'guru_aktif'    => User::guru()->active()->count(),
            'total_siswa'   => Siswa::count(),
            'rppm_disetujui' => Rppm::disetujui()
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->count(),
            'total_porto'   => Portofolio::count(),
        ];

        $penggunaSummary = [
            'admin'  => User::admin()->count(),
            'kepala' => User::kepalaSekolah()->count(),
            'guru'   => User::guru()->count(),
            'ortu'   => User::ortu()->count(),
        ];

        $sekolah = (object)[
            'name'     => $dataSekolah->name ?? '-',
            'npsn'     => $dataSekolah->npsn ?? '-',
            'kepala'   => User::kepalaSekolah()->value('name') ?? '-',
            'alamat'   => $dataSekolah->alamat ?? '-',
            'ta'       => $taAktif?->name ?? '-',
            'semester' => $taAktif?->semester ?? '-',
        ];

        return view('pages.beranda.admin', compact(
            'stats',
            'penggunaSummary',
            'sekolah',
            'taAktif'
        ));
    }

    private function berandaKepala()
    {
        $taAktif = TahunAjaran::getActive();

        $stats = [
            'rppm_menunggu'    => Rppm::pendingValidasi()
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->count(),
            'rpph_menunggu'    => Rpph::pendingValidasi()
                ->whereHas(
                    'rppm',
                    fn($q) =>
                    $q->where('tahun_ajaran_id', $taAktif?->id)
                        ->where('status', 'disetujui')
                )->count(),
            'kegiatan_menunggu' => Kegiatan::pending()->count(),
            'kegiatan_terkunci' => Kegiatan::withJumlahTahun()->disetujui()->terkunci()->count(),
            'rppm_disetujui'    => Rppm::disetujui()
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->count(),
        ];

        $rppmMenunggu = Rppm::with([
            'guru:id,name',
            'subTema:id,name,tema_id',
            'subTema.tema:id,name',
        ])
            ->pendingValidasi()
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->latest()
            ->paginate(5, ['*'], 'rppm_page');

        // Kegiatan terkunci
        $kegiatanTerkunci = Kegiatan::withJumlahTahun()
            ->with(['tema:id,name'])
            ->disetujui()
            ->terkunci()
            ->latest()
            ->get();

        // Ambil tahun dipakai per kegiatan terkunci
        $tahunPerKegiatan = RppmKegiatan::query()
            ->join('rppm', 'rppm.id', '=', 'rppm_kegiatan.rppm_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'rppm.tahun_ajaran_id')
            ->where('rppm.status', 'disetujui')
            ->whereIn('rppm_kegiatan.kegiatan_id', $kegiatanTerkunci->pluck('id'))
            ->select('rppm_kegiatan.kegiatan_id', 'tahun_ajaran.name')
            ->distinct()
            ->orderBy('tahun_ajaran.name')
            ->get()
            ->groupBy('kegiatan_id')
            ->map(fn($rows) => $rows->pluck('name'));

        $sekolah = DataSekolah::getData();

        return view('pages.beranda.kepala', compact(
            'stats',
            'sekolah',
            'rppmMenunggu',
            'kegiatanTerkunci',
            'tahunPerKegiatan',
            'taAktif'
        ));
    }

    private function berandaGuru()
    {
        $guru    = Auth::user();
        $taAktif = TahunAjaran::getActive();
        $kelas   = $guru->kelas;

        $stats = [
            'total_rppm'     => Rppm::olehGuru($guru->id)
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->count(),
            'rppm_disetujui' => Rppm::olehGuru($guru->id)
                ->disetujui()
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->count(),
            'total_rpph'     => Rpph::whereHas(
                'rppm',
                fn($q) =>
                $q->where('guru_id', $guru->id)
                    ->where('tahun_ajaran_id', $taAktif?->id)
            )->count(),
            'siswa_kelas'    => $kelas ? Siswa::where('kelas_id', $kelas->id)->count() : 0,
        ];

        $rppmTerbaru = Rppm::with([
            'subTema:id,name,tema_id',
            'subTema.tema:id,name',
            'rpphs:id,rppm_id,status',
        ])
            ->olehGuru($guru->id)
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->latest()
            ->paginate(5, ['*'], 'rppm_page');

        $siswas = $kelas ? Siswa::where('kelas_id', $kelas->id)
            ->withCount('portofolios')
            ->orderBy('name')
            ->paginate(5, ['*'], 'siswa_page') : collect();

        $sekolah = DataSekolah::getData();

        return view('pages.beranda.guru', compact(
            'stats',
            'sekolah',
            'rppmTerbaru',
            'siswas',
            'kelas',
            'taAktif'
        ));
    }

    private function berandaOrtu()
    {
        $ortu    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $siswas = Siswa::where('ortu_id', $ortu->id)
            ->with('kelas:id,name')
            ->get(['id', 'name', 'jenis_kelamin', 'kelas_id']);

        $dataAnak = $siswas->map(function ($siswa) use ($ortu, $taAktif) {
            $kelasIds = [$siswa->kelas_id];

            return [
                'siswa'         => $siswa,
                'porto_count'   => Portofolio::where('siswa_id', $siswa->id)->count(),
                'rppm_aktif'    => Rppm::disetujui()
                    ->where('tahun_ajaran_id', $taAktif?->id)
                    ->whereHas(
                        'guru.kelas',
                        fn($q) =>
                        $q->whereIn('id', $kelasIds)
                    )->count(),
                'komentar_saya' => KomentarPortofolio::where('user_id', $ortu->id)
                    ->whereHas(
                        'portofolio',
                        fn($q) =>
                        $q->where('siswa_id', $siswa->id)
                    )->count(),
            ];
        });

        $sekolah = DataSekolah::getData();

        return view('pages.beranda.ortu', compact(
            'dataAnak',
            'sekolah',
            'ortu',
            'taAktif'
        ));
    }
}
