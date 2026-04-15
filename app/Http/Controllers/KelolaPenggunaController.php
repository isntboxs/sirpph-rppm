<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KelolaPenggunaController extends Controller
{
    public function index()
    {
        $users = User::with(['kelas', 'siswas'])->get();

        return view('pages.kelola_pengguna.index', compact('users'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:guru,ortu',
            'no_hp'    => 'nullable|string|max:20',
        ];

        // Rule if Guru
        if ($request->role === 'guru') {
            $rules['kelas'] = 'required|exists:kelas,id';
        }

        // Rule if Ortu
        if ($request->role === 'ortu') {
            $rules['siswa_dipantau'] = 'required|array|min:1';
            $rules['siswa_dipantau.*'] = 'exists:siswa,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::transaction(function () use ($request, &$user) {
                // Create new User
                $user_data = [
                    'name'     => $request->name,
                    'username' => $request->username,
                    'password' => $request->password,
                    'role'     => $request->role,
                    'no_telp'  => $request->no_hp,
                    'active'   => 1,
                ];

                $user = User::create($user_data);

                // Update kelas if role guru 
                if ($request->role === 'guru') {
                    Kelas::where('id', $request->kelas)
                        ->update(['guru_id' => $user->id]);
                }

                // Update siswa if role ortu 
                if ($request->role === 'ortu') {
                    Siswa::whereIn('id', $request->siswa_dipantau)
                        ->update(['ortu_id' => $user->id]);
                }
            });

            return response()->json([
                'status' => true,
                'msg' => 'User berhasil ditambahkan',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $user = DB::table('users')
            ->leftJoin('kelas', 'kelas.guru_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.role',
                'users.no_telp',
                'kelas.id as kelas_id',
                'kelas.name as kelas_name'
            )
            ->where('users.id', $id)
            ->first();

        if ($user->role === 'ortu') {
            $siswas = DB::table('siswa')
                ->select(
                    'id',
                    'name',
                    DB::raw("CASE 
                    WHEN ortu_id = ? THEN 1 
                    ELSE 0 
                END as related")
                )
                ->setBindings([$user->id])
                ->get();
        }

        dd($siswas);

        return response()->json([
            'user' => $user,
            'siswas' => $siswas
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'role'     => 'required|in:admin,kepala,guru,ortu',
            'no_hp'    => 'nullable|string|max:20',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }

        if ($request->role === 'guru') {
            $rules['kelas'] = 'required|exists:kelas,id';
        }

        if ($request->role === 'ortu') {
            $rules['siswa_dipantau'] = 'required|array|min:1';
            $rules['siswa_dipantau.*'] = 'exists:siswa,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::transaction(function () use ($request, $user) {
                $data = [
                    'name'     => $request->name,
                    'username' => $request->username,
                    'role'     => $request->role,
                    'no_telp'  => $request->no_hp,
                ];

                if ($request->filled('password')) {
                    $data['password'] = $request->password;
                }

                $user->update($data);

                Kelas::where('guru_id', $user->id)->update(['guru_id' => null]);
                Siswa::where('ortu_id', $user->id)->update(['ortu_id' => null]);

                if ($request->role === 'guru') {
                    Kelas::where('id', $request->kelas)
                        ->update(['guru_id' => $user->id]);
                }

                if ($request->role === 'ortu') {
                    Siswa::whereIn('id', $request->siswa_dipantau)
                        ->update(['ortu_id' => $user->id]);
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'User berhasil diupdate',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
