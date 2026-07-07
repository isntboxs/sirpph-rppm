<?php

namespace App\Http\Controllers;

use App\Models\DataSekolah;
use Illuminate\Support\Facades\Auth;
use App\Models\Rppm;
use App\Models\Rpph;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakController extends Controller
{
    public function rppm(string $id)
    {
        $rppm = Rppm::with([
            'guru:id,name',
            'guru.kelas:id,name,guru_id',
            'tahunAjaran:id,name,semester',
            'subTema:id,tema_id,name,minggu_ke',
            'subTema.tema:id,name'
        ])->findOrFail((int) $id);

        $user = Auth::user();
        abort_if(
            !in_array($user->role, ['admin', 'kepala'])
            && $rppm->guru_id !== $user->id,
            403
        );

        $pdf = Pdf::loadView('pages.rppm.pdf', compact('rppm'));
        $filename = 'RPP_Mingguan_' . ($rppm->guru?->name ?? 'Guru') . '_Minggu_' . ($rppm->subTema?->minggu_ke ?? '') . '_' . time() . '.pdf';
        
        return $pdf->stream($filename)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}