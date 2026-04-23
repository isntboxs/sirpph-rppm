<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tema;
use App\Models\SubTema;

class KelolaTemaController extends Controller
{
    public function index()
    {
        $temas = Tema::with('subTemas')->orderBy('semester')->get();

        return view('pages.kelola_tema.index', compact('temas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:100|unique:tema,name',
            'semester'  => 'required|in:1,2',
            'sub_tema'  => 'required|array|min:1',
            'sub_tema.*'=> 'required|string|max:100',
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

        $tema = Tema::create([
            'name'     => $request->name,
            'semester' => $request->semester,
        ]);

        foreach ($request->sub_tema as $subNama) {
            if (!empty(trim($subNama))) {
                SubTema::create([
                    'tema_id' => $tema->id,
                    'name'    => trim($subNama),
                ]);
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil ditambahkan.',
        ]);
    }

    public function destroy(int $id)
    {
        $tema = Tema::findOrFail($id);
        $tema->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil dihapus.',
        ]);
    }

    public function storeSubTema(Request $request, int $temaId)
    {
        $tema = Tema::findOrFail($temaId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:sub_tema,name,NULL,id,tema_id,' . $temaId,
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
            'tema_id' => $tema->id,
            'name'    => $request->name,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Sub tema berhasil ditambahkan.',
            'data'    => $subTema,
        ]);
    }

    public function destroySubTema(int $id)
    {
        $subTema = SubTema::findOrFail($id);
        $subTema->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Sub tema berhasil dihapus.',
        ]);
    }
}