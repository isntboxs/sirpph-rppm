<?php

namespace App\Http\Controllers;

use App\Models\LaporanRpp;
use App\Models\LaporanRppFoto;
use App\Models\Rppm;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanRppController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user();
        $taAktif = TahunAjaran::getActive();

        $query = LaporanRpp::with(['rppm' => function($q) {
            $q->select('id', 'tahun_ajaran_id', 'sub_tema_id', 'minggu_ke', 'status');
        }, 'rppm.subTema.tema', 'fotos'])
            ->where('guru_id', $guru->id)
            ->whereHas('rppm', function($q) use ($taAktif) {
                $q->where('tahun_ajaran_id', $taAktif?->id)
                  ->where('status', 'disetujui');
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('rppm.subTema.tema', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        $laporans = $query->latest()->get();
        $stats = [
            $baseQuery = LaporanRpp::where('guru_id', $guru->id)->whereHas('rppm', function($q) use ($taAktif) {
                $q->where('tahun_ajaran_id', $taAktif?->id)->where('status', 'disetujui');
            }),
            'total' => (clone $baseQuery)->count(),
            'disetujui' => (clone $baseQuery)->where('status', 'disetujui')->count(),
            'menunggu' => (clone $baseQuery)->where('status', 'pending')->count(),
        ];

        return view('pages.laporan_rpp.index', compact('laporans', 'stats', 'taAktif'));
    }



    public function show($id)
    {
        $laporan = LaporanRpp::with(['rppm' => function($q) {
            $q->select('id', 'tahun_ajaran_id', 'sub_tema_id', 'minggu_ke', 'status');
        }, 'rppm.subTema.tema', 'fotos'])->findOrFail($id);
        abort_if($laporan->guru_id !== Auth::id() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'kepala', 403);
        
        $rppms = Rppm::with(['subTema.tema'])
            ->select('id', 'tahun_ajaran_id', 'sub_tema_id', 'minggu_ke', 'status')
            ->where('id', $laporan->rppm_id)
            ->get();

        return view('pages.laporan_rpp.form', compact('laporan', 'rppms'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanRpp::findOrFail($id);
        abort_if($laporan->guru_id !== Auth::id(), 403);
        abort_if($laporan->status === 'disetujui', 422, 'Laporan yang sudah disetujui tidak bisa diedit.');
        abort_if($laporan->rppm->status !== 'disetujui', 422, 'RPP induk belum disetujui.');
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan_singkat' => 'required|string',
            'foto_bersama.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_karya.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'hapus_foto' => 'nullable|array',
        ]);

        $laporan->update([
            'tanggal' => $request->tanggal,
            'keterangan_singkat' => $request->keterangan_singkat,
            'status' => $request->action === 'send' ? 'pending' : $laporan->status,
        ]);

        if ($request->hasFile('foto_bersama')) {
            foreach ($request->file('foto_bersama') as $file) {
                $path = $file->store('laporan_rpp_fotos', 'public');
                LaporanRppFoto::create([
                    'laporan_rpp_id' => $laporan->id,
                    'jenis' => 'bersama',
                    'path' => $path,
                ]);
            }
        }
        
        if ($request->hasFile('foto_karya')) {
            foreach ($request->file('foto_karya') as $file) {
                $path = $file->store('laporan_rpp_fotos', 'public');
                LaporanRppFoto::create([
                    'laporan_rpp_id' => $laporan->id,
                    'jenis' => 'karya',
                    'path' => $path,
                ]);
            }
        }
        
        // hapus foto yg dicentang
        if ($request->has('hapus_foto')) {
            foreach ($request->hapus_foto as $fotoId) {
                $foto = LaporanRppFoto::find($fotoId);
                if ($foto && $foto->laporan_rpp_id == $laporan->id) {
                    Storage::disk('public')->delete($foto->path);
                    $foto->delete();
                }
            }
        }

        if ($request->action === 'send') {
            $this->kirimNotifikasi($laporan);
            return redirect()->route('laporan_rpp')->with('success', 'Laporan berhasil dikirim!');
        }

        return redirect()->route('laporan_rpp')->with('success', 'Laporan berhasil diperbarui!');
    }



    private function kirimNotifikasi(LaporanRpp $laporan)
    {
        $usersToNotify = User::whereIn('role', ['admin', 'kepala'])->get();
        foreach ($usersToNotify as $user) {
            $user->notify(new GeneralNotification(
                'Laporan RPP Baru',
                'Guru ' . Auth::user()->name . ' telah mengirimkan Laporan RPP untuk Minggu ' . $laporan->rppm->minggu_ke,
                route('validasi_laporan') // tautan ke halaman validasi laporan
            ));
        }
    }
}
