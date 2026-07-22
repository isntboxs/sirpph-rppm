<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Rppm;
use App\Models\RppmKegiatan;
use App\Models\Rpph;
use App\Models\Kegiatan;
use App\Models\Tema;
use App\Models\TahunAjaran;
use App\Models\AspekPerkembangan;
use App\Models\User;
use App\Notifications\RppmDiajukan;

class RppmController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $taAktif = TahunAjaran::getActive();

        if (!$taAktif) {
            return view('pages.rppm.index', [
                'taAktif' => null,
                'mingguBerjalan' => 0,
                'semesterLabel' => '-',
                'rppms' => collect(),
                'rppmsGrouped' => [],
                'gurus' => collect(),
                'rppmTerisi' => 0
            ]);
        }

        // Simulasi minggu berjalan berdasarkan bulan saat ini
        $bulanMulai = $taAktif->semester == 1 ? 7 : 1;
        $tahunMulai = $taAktif->semester == 1 ? (int) substr($taAktif->name, 0, 4) : (int) substr($taAktif->name, 5, 4);
        
        $tanggalMulai = \Carbon\Carbon::create($tahunMulai, $bulanMulai, 1);
        $mingguBerjalan = max(1, min(17, $tanggalMulai->diffInWeeks(now()) + 1));
        $semesterLabel = $taAktif->semester == 1 ? 'Ganjil' : 'Genap';

        if ($user->isAdmin()) {
            $gurus = User::guru()->active()->with('kelas')->get();
            $allRppms = Rppm::with(['subTema.tema', 'tahunAjaran'])
                ->whereIn('guru_id', $gurus->pluck('id'))
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->get();
            $rppmsGrouped = $allRppms->groupBy('guru_id');
            return view('pages.rppm.index', compact(
                'gurus',
                'rppmsGrouped',
                'taAktif',
                'mingguBerjalan',
                'semesterLabel'
            ));
        } else {
            if ($taAktif) {
                Rppm::syncDraftsForGuru($user->id, $taAktif->id);
            }
            $rppms = Rppm::with(['subTema.tema', 'tahunAjaran'])
                ->olehGuru($user->id)
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->get();
            $rppmTerisi = $rppms->count();

            return view('pages.rppm.index', compact(
                'rppms',
                'taAktif',
                'mingguBerjalan',
                'semesterLabel',
                'rppmTerisi'
            ));
        }
    }

    public function create(Request $request)
    {
        $taAktif = TahunAjaran::getActive();
        if (!$taAktif) {
            return redirect()->route('rppm.index')->with('error', 'Harap atur Tahun Ajaran aktif terlebih dahulu.');
        }

        $gurus = User::guru()->active()->with('kelas')->get();
        $temas = Tema::with('subTemas')->get();
        
        // Kalau tidak ada RPP, buat instance baru agar tidak error di view
        $rppm = new Rppm([
            'tahun_ajaran_id' => $taAktif?->id,
            'tanggal_dibuat' => now()->toDateString(),
        ]);
        
        return view('pages.rppm.form', compact('rppm', 'taAktif', 'gurus', 'temas'));
    }

    public function store(Request $request)
    {
        $guruId = Auth::user()->isAdmin() ? $request->guru_id : Auth::id();

        $request->validate([
            'guru_id'         => Auth::user()->isAdmin() ? 'required|exists:users,id' : 'nullable',
            'tahun_ajaran_id' => 'required',
            'minggu_ke'       => 'required|integer|min:1|max:17',
            'sub_tema_id'     => [
                'required',
                \Illuminate\Validation\Rule::unique('rppm')->where(function ($query) use ($guruId, $request) {
                    return $query->where('guru_id', $guruId)
                                 ->where('tahun_ajaran_id', $request->tahun_ajaran_id);
                })
            ],
            'tanggal_dibuat'  => 'required|date',
            'tujuan'          => 'nullable|string',
            'capaian'         => 'nullable|string',
            'kegiatan_pembuka'=> 'nullable|string',
            'kegiatan_inti'   => $request->input('action') === 'ajukan' ? 'required|string' : 'nullable|string',
            'recalling'       => 'nullable|string',
            'kegiatan_penutup'=> 'nullable|string',
            'rencana_penilaian'=> 'nullable|string',
        ], [
            'sub_tema_id.unique' => 'RPP untuk Sub Tema ini sudah pernah dibuat sebelumnya! Silakan pilih Sub Tema lain atau edit RPP yang sudah ada.',
        ]);

        $rppm = Rppm::create([
            'guru_id'         => Auth::user()->isAdmin() ? $request->guru_id : Auth::id(),
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'sub_tema_id'     => $request->sub_tema_id,
            'minggu_ke'       => $request->minggu_ke,
            'tanggal_dibuat'  => $request->tanggal_dibuat,
            'tujuan'          => $request->tujuan,
            'capaian'         => $request->capaian,
            'kegiatan_pembuka'=> $request->kegiatan_pembuka,
            'kegiatan_inti'   => $request->kegiatan_inti,
            'recalling'       => $request->recalling,
            'kegiatan_penutup'=> $request->kegiatan_penutup,
            'rencana_penilaian'=> $request->rencana_penilaian,
            'status'          => $request->input('action') === 'ajukan' ? 'pending' : 'draft',
        ]);
        
        if ($request->input('action') === 'ajukan') {
            User::kepalaSekolah()->active()->each(function ($kepala) use ($rppm) {
                $kepala->notify(new RppmDiajukan($rppm));
            });
            return redirect()->route('rppm')->with('success', 'RPP berhasil dibuat dan diajukan ke Kepala Sekolah!');
        }

        return redirect()->route('rppm')->with('success', 'RPP berhasil dibuat (Disimpan sebagai Draft)!');
    }

    public function show($id)
    {
        $rppm = Rppm::with(['subTema.tema', 'tahunAjaran'])->findOrFail($id);
        
        // Cek akses
        if (Auth::user()->role === 'guru') {
            abort_if($rppm->guru_id !== Auth::id(), 403);
        }

        $taAktif = TahunAjaran::getActive();
        $gurus = User::guru()->active()->with('kelas')->get();
        $temas = Tema::with('subTemas')->get();
        $subTemas = \App\Models\SubTema::where('tema_id', $rppm->subTema->tema_id ?? 0)->get();

        return view('pages.rppm.form', compact('rppm', 'taAktif', 'gurus', 'temas', 'subTemas'));
    }

    public function update(Request $request, $id)
    {
        $rppm = Rppm::findOrFail($id);
        if (Auth::user()->role === 'guru') {
            abort_if($rppm->guru_id !== Auth::id(), 403);
        }

        if ($rppm->status === 'disetujui' && !in_array($request->input('action'), ['ajukan', 'draft'])) {
            return redirect()->route('rppm')->with('error', 'RPP sudah disetujui dan tidak dapat diubah tanpa diajukan ulang.');
        }

        $request->validate([
            'tanggal_dibuat'  => 'required|date',
            'tujuan'          => 'nullable|string',
            'capaian'         => 'nullable|string',
            'kegiatan_pembuka'=> 'nullable|string',
            'kegiatan_inti'   => $request->input('action') === 'ajukan' ? 'required|string' : 'nullable|string',
            'recalling'       => 'nullable|string',
            'kegiatan_penutup'=> 'nullable|string',
            'rencana_penilaian'=> 'nullable|string',
        ]);

        $rppm->update([
            'tanggal_dibuat'  => $request->tanggal_dibuat,
            'tujuan'          => $request->tujuan,
            'capaian'         => $request->capaian,
            'kegiatan_pembuka'=> $request->kegiatan_pembuka,
            'kegiatan_inti'   => $request->kegiatan_inti,
            'recalling'       => $request->recalling,
            'kegiatan_penutup'=> $request->kegiatan_penutup,
            'rencana_penilaian'=> $request->rencana_penilaian,
        ]);
        
        if ($request->input('action') === 'ajukan') {
            $rppm->update(['status' => 'pending', 'catatan_kepala' => null]);
            User::kepalaSekolah()->active()->each(function ($kepala) use ($rppm) {
                $kepala->notify(new RppmDiajukan($rppm));
            });
            return redirect()->route('rppm')->with('success', 'RPP berhasil diperbarui dan diajukan ke Kepala Sekolah!');
        }

        return redirect()->route('rppm')->with('success', 'RPP berhasil diperbarui!');
    }



    public function ajukan(int $id)
    {
        $rppm = Rppm::findOrFail($id);
        abort_if($rppm->guru_id !== Auth::id() && Auth::user()->role !== 'admin', 403);

        if (empty($rppm->kegiatan_inti)) {
            return response()->json([
                'status'  => false,
                'message' => 'Kegiatan Inti belum diisi.',
            ], 422);
        }

        $rppm->update(['status' => 'pending', 'catatan_kepala' => null]);

        User::kepalaSekolah()->active()->each(function ($kepala) use ($rppm) {
            $kepala->notify(new RppmDiajukan($rppm));
        });

        return response()->json([
            'status'  => true,
            'message' => '📤 RPP berhasil diajukan ke Kepala Sekolah.',
        ]);
    }



    public function destroy(string $id)
    {
        $rppm = Rppm::findOrFail((int) $id);

        abort_if($rppm->guru_id !== Auth::id() && Auth::user()->role !== 'admin', 403);

        if ($rppm->status === 'disetujui') {
            return response()->json([
                'status'  => false,
                'message' => 'RPP yang sudah disetujui tidak bisa dihapus.',
            ], 422);
        }

        $rppm->delete();

        return response()->json([
            'status'  => true,
            'message' => '🗑️ RPP berhasil dihapus. Kamu bisa membuat RPP baru untuk minggu tersebut.',
        ]);
    }

    public function cetakPdf($id)
    {
        $rppm = Rppm::with(['guru', 'subTema.tema', 'tahunAjaran', 'laporanRpp'])->findOrFail($id);
        
        $user = Auth::user();
        abort_if(
            !in_array($user->role, ['admin', 'kepala'])
            && $rppm->guru_id !== $user->id,
            403
        );

        $pdf = Pdf::loadView('pages.rppm.pdf', compact('rppm'));
        $filename = 'RPP_' . ($rppm->guru?->name ?? 'Guru') . '_Minggu_' . ($rppm->subTema?->minggu_ke ?? '') . '.pdf';
        
        return $pdf->stream($filename);
    }
}
