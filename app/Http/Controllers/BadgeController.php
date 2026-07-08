<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Rpph;
use App\Models\Rppm;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function update(Request $request)
    {
        $taAktif = TahunAjaran::getActive();

        return response()->json([
            'rppm_count'     => Rppm::pendingValidasi()
                ->where('tahun_ajaran_id', $taAktif?->id)
                ->count(),
            'rpph_count'     => 0,
            'kegiatan_count' => 0
        ]);
    }
}
