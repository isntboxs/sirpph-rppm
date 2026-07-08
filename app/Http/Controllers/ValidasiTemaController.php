<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\SubTema;
use App\Notifications\GeneralNotification;
use App\Models\User;

class ValidasiTemaController extends Controller
{
    public function index()
    {
        $taAktif = \App\Models\TahunAjaran::getActive();
        
        $temaPending = Tema::with(['user', 'subTemas' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->whereIn('status', ['pending', 'dikembalikan', 'disetujui'])
            ->latest()
            ->paginate(10);

        return view('pages.validasi_tema.index', compact('temaPending', 'taAktif'));
    }

    public function setujuiTema($id)
    {
        $tema = Tema::findOrFail($id);
        $tema->update(['status' => 'disetujui']);

        if ($tema->edited_by) {
            $user = User::find($tema->edited_by);
            if ($user) {
                $user->notify(new GeneralNotification(
                    'Tema Disetujui',
                    'Tema "' . $tema->name . '" telah disetujui oleh Kepala Sekolah.',
                    route('kelola_tema')
                ));
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Tema berhasil disetujui.'
        ]);
    }

    public function kembalikanTema(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        $tema = Tema::findOrFail($id);
        $tema->update([
            'status' => 'dikembalikan',
            'alasan_edit' => $request->catatan // Menggunakan kolom alasan_edit/alasan_revisi yg ada
        ]);

        if ($tema->edited_by) {
            $user = User::find($tema->edited_by);
            if ($user) {
                $user->notify(new GeneralNotification(
                    'Tema Dikembalikan',
                    'Tema "' . $tema->name . '" dikembalikan. Catatan: ' . $request->catatan,
                    route('kelola_tema')
                ));
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Tema berhasil dikembalikan.'
        ]);
    }

    public function setujuiSubTema($id)
    {
        $subTema = SubTema::findOrFail($id);
        abort_if($subTema->tema->status !== 'disetujui', 422, 'Tema induk belum disetujui.');
        $subTema->update(['status' => 'disetujui']);

        if ($subTema->edited_by) {
            $user = User::find($subTema->edited_by);
            if ($user) {
                $user->notify(new GeneralNotification(
                    'Sub Tema Disetujui',
                    'Sub Tema "' . $subTema->name . '" telah disetujui oleh Kepala Sekolah.',
                    route('kelola_tema')
                ));
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Sub Tema berhasil disetujui.'
        ]);
    }

    public function kembalikanSubTema(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        $subTema = SubTema::findOrFail($id);
        $subTema->update([
            'status' => 'dikembalikan',
            'alasan_edit' => $request->catatan
        ]);

        if ($subTema->edited_by) {
            $user = User::find($subTema->edited_by);
            if ($user) {
                $user->notify(new GeneralNotification(
                    'Sub Tema Dikembalikan',
                    'Sub Tema "' . $subTema->name . '" dikembalikan. Catatan: ' . $request->catatan,
                    route('kelola_tema')
                ));
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Sub Tema berhasil dikembalikan.'
        ]);
    }
}
