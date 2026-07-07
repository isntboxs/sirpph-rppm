<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Tema;
use App\Models\SubTema;

class KelolaTemaController extends Controller
{
    public function index()
    {
        $taAktif = \App\Models\TahunAjaran::getActive();
        $temas = Tema::with('subTemas')
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->orderBy('semester')
            ->get();

        return view('pages.kelola_tema.index', compact('temas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:100|unique:tema,name',
            'semester'  => 'required|in:1,2',
            'sub_tema'  => 'required|array|min:1',
            'sub_tema.*.name' => 'required|string|max:100',
            'sub_tema.*.minggu_ke' => 'required|integer|min:1',
        ], [
            'name.required'     => 'Nama tema wajib diisi.',
            'name.unique'       => 'Tema sudah ada.',
            'semester.required' => 'Semester wajib dipilih.',
            'semester.in'       => 'Semester tidak valid.',
            'sub_tema.required' => 'Minimal 1 sub tema wajib diisi.',
            'sub_tema.min'      => 'Minimal 1 sub tema wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $taAktif = \App\Models\TahunAjaran::getActive();
        if (!$taAktif) {
            return response()->json(['status' => false, 'errors' => ['name' => ['Tahun Ajaran aktif belum diatur']]], 422);
        }

        $tema = Tema::create([
            'tahun_ajaran_id' => $taAktif->id,
            'name'     => $request->name,
            'semester' => $request->semester,
            'status'   => 'draft',
        ]);

        foreach ($request->sub_tema as $st) {
            if (!empty(trim($st['name']))) {
                SubTema::create([
                    'tema_id'   => $tema->id,
                    'name'      => trim($st['name']),
                    'minggu_ke' => $st['minggu_ke'],
                    'status'    => 'draft',
                ]);
            }
        }

        $taAktif = \App\Models\TahunAjaran::getActive();
        if ($taAktif) {
            \App\Models\Rppm::syncDraftsForAllGurus($taAktif->id);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil ditambahkan.',
        ]);
    }

    public function destroy(int $id)
    {
        $tema = Tema::findOrFail($id);
        // hapus semua Rppm dari setiap subtema tersebut
        foreach ($tema->subTemas as $st) {
            $rppms = \App\Models\Rppm::where('sub_tema_id', $st->id)->get();
            foreach ($rppms as $rppm) {
                \App\Models\LaporanRpp::where('rppm_id', $rppm->id)->delete();
                $rppm->delete();
            }
        }
        $tema->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil dihapus.',
        ]);
    }

    public function update(Request $request, int $id)
    {
        try {
            $tema = Tema::findOrFail($id);
            
            $rules = [
                'name' => 'required|string|max:100|unique:tema,name,' . $id,
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $tema->update([
                'name' => $request->name,
                'edited_by' => Auth::id(),
                'status' => 'draft', // Selalu draft, agar diajukan berbarengan via tombol Ajukan di depan
            ]);



            return response()->json([
                'status'  => true,
                'message' => 'Tema berhasil diedit dan disimpan sebagai draft.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => ['name' => ['Terjadi kesalahan server: ' . $e->getMessage() . ' di ' . $e->getFile() . ':' . $e->getLine()]]
            ], 500);
        }
    }

    public function ajukan(int $id)
    {
        try {
            $tema = Tema::findOrFail($id);
            if ($tema->status !== 'disetujui') {
                $tema->update(['status' => 'pending', 'edited_by' => Auth::id()]);
            }
            $tema->subTemas()->whereIn('status', ['draft', 'dikembalikan'])->update(['status' => 'pending', 'edited_by' => Auth::id()]);

            \App\Models\User::kepalaSekolah()->active()->each(function ($kepala) use ($tema) {
                // Notifikasi tema diajukan
                $kepala->notify(new \App\Notifications\GeneralNotification(
                    'Validasi Tema Baru',
                    'Tema "' . $tema->name . '" diajukan untuk divalidasi.',
                    '/validasi-tema?highlight_tema=' . $tema->id
                ));
            });

            return response()->json([
                'status'  => true,
                'message' => 'Tema berhasil diajukan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengajukan tema.'
            ], 500);
        }
    }

    public function storeSubTema(Request $request, int $temaId)
    {
        $tema = Tema::findOrFail($temaId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:sub_tema,name,NULL,id,tema_id,' . $temaId,
            'minggu_ke' => 'required|integer|min:1',
        ], [
            'name.required' => 'Nama sub tema wajib diisi.',
            'name.unique'   => 'Sub tema sudah ada di tema ini.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $subTema = SubTema::create([
            'tema_id'   => $tema->id,
            'name'      => $request->name,
            'minggu_ke' => $request->minggu_ke,
            'status'    => 'draft',
        ]);

        $taAktif = \App\Models\TahunAjaran::getActive();
        if ($taAktif) {
            \App\Models\Rppm::syncDraftsForAllGurus($taAktif->id);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Sub tema berhasil ditambahkan.',
            'data'    => $subTema,
        ]);
    }

    public function destroySubTema(int $id)
    {
        $subTema = SubTema::findOrFail($id);
        
        $rppms = \App\Models\Rppm::where('sub_tema_id', $subTema->id)->get();
        foreach ($rppms as $rppm) {
            \App\Models\LaporanRpp::where('rppm_id', $rppm->id)->delete();
            $rppm->delete();
        }
        
        $subTema->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Sub tema berhasil dihapus.',
        ]);
    }

    public function updateSubTema(Request $request, int $id)
    {
        try {
            $subTema = SubTema::findOrFail($id);

            $rules = [
                'name' => 'required|string|max:100|unique:sub_tema,name,' . $id . ',id,tema_id,' . $subTema->tema_id,
                'minggu_ke' => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $subTema->update([
                'name' => $request->name,
                'minggu_ke' => $request->minggu_ke,
                'edited_by' => Auth::id(),
                'status' => 'draft',
            ]);



            return response()->json([
                'status'  => true,
                'message' => 'Sub tema berhasil diedit dan disimpan sebagai draft.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => ['name' => ['Terjadi kesalahan server: ' . $e->getMessage() . ' di ' . $e->getFile() . ':' . $e->getLine()]]
            ], 500);
        }
    }
}