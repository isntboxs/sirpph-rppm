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
        ];

        $penggunaSummary = [
            'admin'  => User::admin()->count(),
            'kepala' => User::kepalaSekolah()->count(),
            'guru'   => User::guru()->count(),
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

        // hitung statistik rppm
        $rppTotal = Rppm::where('tahun_ajaran_id', $taAktif?->id)->where('status', '!=', 'draft')->count();
        $rppPending = Rppm::where('tahun_ajaran_id', $taAktif?->id)->where('status', 'pending')->count();

        // hitung statistik laporan rpp
        $laporanTotal = \App\Models\LaporanRpp::whereHas('rppm', function($q) use ($taAktif) {
            $q->where('tahun_ajaran_id', $taAktif?->id);
        })->where('status', '!=', 'draft')->count();
        $laporanPending = \App\Models\LaporanRpp::whereHas('rppm', function($q) use ($taAktif) {
            $q->where('tahun_ajaran_id', $taAktif?->id);
        })->where('status', 'pending')->count();

        // hitung statistik tema
        $temaTotal = \App\Models\Tema::where('tahun_ajaran_id', $taAktif?->id)->count();
        $temaPending = \App\Models\Tema::where('tahun_ajaran_id', $taAktif?->id)->where('status', 'pending')->count();

        // hitung statistik sub tema
        $subTemaTotal = \App\Models\SubTema::whereHas('tema', function($q) use ($taAktif) {
            $q->where('tahun_ajaran_id', $taAktif?->id);
        })->count();
        $subTemaPending = \App\Models\SubTema::whereHas('tema', function($q) use ($taAktif) {
            $q->where('tahun_ajaran_id', $taAktif?->id);
        })->where('status', 'pending')->count();

        $stats = [
            'rpp' => ['total' => $rppTotal, 'pending' => $rppPending],
            'laporan' => ['total' => $laporanTotal, 'pending' => $laporanPending],
            'tema' => ['total' => $temaTotal, 'pending' => $temaPending],
            'sub_tema' => ['total' => $subTemaTotal, 'pending' => $subTemaPending],
        ];

        $sekolah = DataSekolah::getData();

        return view('pages.beranda.kepala', compact(
            'stats',
            'sekolah',
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
                ->where('status', '!=', 'draft')
                ->count(),
            'total_laporan'  => \App\Models\LaporanRpp::where('guru_id', $guru->id)
                ->whereHas('rppm', function($q) use ($taAktif) {
                    $q->where('tahun_ajaran_id', $taAktif?->id);
                })
                ->where('status', '!=', 'draft')
                ->count(),
        ];

        $sekolah = DataSekolah::getData();

        return view('pages.beranda.guru', compact(
            'stats',
            'sekolah',
            'kelas',
            'taAktif'
        ));
    }


}
