<?php

namespace App\Http\Controllers;

use App\Models\DataSekolah;
use Illuminate\Support\Facades\Auth;
use App\Models\Rppm;
use App\Models\Rpph;
use App\Models\User;

class CetakController extends Controller
{
    public function rppm(string $id)
    {
        $rppm = Rppm::with([
            'guru:id,name',
            'guru.kelas:id,name,guru_id',
            'tahunAjaran:id,name,semester',
            'subTema:id,name,tema_id',
            'subTema.tema:id,name',
            'rppmKegiatans' => fn($q) => $q->orderBy('hari')->orderBy('urutan'),
            'rppmKegiatans.kegiatan.aspeks:id,name,emote',
            'rppmKegiatans.kegiatan.bentukKegiatan:id,name',
            'rppmKegiatans.kegiatan.alatBahans:id,name',
        ])->findOrFail((int) $id);

        $user = Auth::user();
        abort_if(
            !in_array($user->role, ['admin', 'kepala'])
            && $rppm->guru_id !== $user->id,
            403
        );

        $dataSekolah = DataSekolah::getData();

        $sekolah = (object)[
            'name'    => $dataSekolah->name,
            'npsn'    => $dataSekolah->npsn,
            'alamat'  => $dataSekolah->alamat,
            'kepala'  => User::kepalaSekolah()->value('name'),
        ];

        return view('export.rppm', compact('rppm', 'sekolah'));
    }

    public function rpph(string $id)
    {
        $rpph = Rpph::with([
            'rppm.guru:id,name',
            'rppm.guru.kelas:id,name,guru_id',
            'rppm.tahunAjaran:id,name,semester',
            'rppm.subTema:id,name,tema_id',
            'rppm.subTema.tema:id,name',
            'rppm.rppmKegiatans' => fn($q, $rpph = null) => $q->orderBy('urutan'),
            'rppm.rppmKegiatans.kegiatan.aspeks:id,name',
            'rppm.rppmKegiatans.kegiatan.bentukKegiatan:id,name',
            'rppm.rppmKegiatans.kegiatan.alatBahans:id,name',
            'kelas:id,name',
            'penilaians.poins',
        ])->findOrFail((int) $id);

        $user = Auth::user();
        abort_if(
            !in_array($user->role, ['admin', 'kepala'])
            && $rpph->rppm->guru_id !== $user->id,
            403
        );

        // Filter kegiatan hanya hari ini
        $kegiatanHari = $rpph->rppm->rppmKegiatans
            ->where('hari', $rpph->hari)
            ->values();

        $sekolah = (object)[
            'name'    => config('sekolah.name', 'PAUDQu AL-AULIA'),
            'npsn'    => config('sekolah.npsn', '69990123'),
            'alamat'  => config('sekolah.alamat', 'Jl. Al Quran No.12, Serang, Banten'),
            'kepala'  => config('sekolah.kepala', 'Kepala Sekolah'),
        ];

        return view('pages.cetak.rpph', compact('rpph', 'kegiatanHari', 'sekolah'));
    }
}