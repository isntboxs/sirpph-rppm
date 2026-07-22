<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KelolaPenggunaController extends Controller
{
    public function index()
    {
        $users = User::with(['kelas'])->get();
        $kelas = Kelas::all();
        $roles = Role::all();

        return view('pages.kelola_pengguna.index', compact('users', 'kelas', 'roles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'role'     => 'required|exists:roles,id',
            'no_telp'  => 'nullable|string|max:20',
        ];

        // kalo dia guru, wajib pilih kelas
        if ($request->role === 'guru') {
            $rules['kelas'] = 'required|exists:kelas,id';
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
                // bikin user baru
                $user_data = [
                    'name'     => $request->name,
                    'username' => $request->username,
                    'password' => $request->password,
                    'role'     => $request->role,
                    'no_telp'  => $request->no_telp,
                    'active'   => 1,
                ];

                $user = User::create($user_data);

                // set kelasnya kalo dia guru
                if ($request->role === 'guru') {
                    Kelas::where('guru_id', $user->id)->update(['guru_id' => null]);
                    Kelas::where('id', $request->kelas)
                        ->update(['guru_id' => $user->id]);
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
        $user = User::leftJoin('kelas', 'kelas.guru_id', '=', 'users.id')
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

        return response()->json([
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'role'     => 'required|exists:roles,id',
            'no_telp'    => 'nullable|string|max:20',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }

        if ($request->role === 'guru') {
            $rules['kelas'] = 'required|exists:kelas,id';
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
                    'no_telp'  => $request->no_telp,
                ];

                if ($request->filled('password')) {
                    $data['password'] = $request->password;
                }

                $user->update($data);

                if ($request->role === 'guru') {
                    Kelas::where('guru_id', $user->id)->update(['guru_id' => null]);
                    Kelas::where('id', $request->kelas)
                        ->update(['guru_id' => $user->id]);
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

    public function destroy(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($request->command === 'activate') {
                $user->active = 1;
                $user->save();
                return response()->json(['message' => 'User berhasil diaktifkan']);
            }

            DB::transaction(function () use ($id, $user) {
                // hapus ikatan guru di kelas (jadiin null)
                Kelas::where('guru_id', $id)->update(['guru_id' => null]);
                
                // hapus foto laporan
                $laporanIds = \App\Models\LaporanRpp::where('guru_id', $id)->pluck('id');
                $fotos = \App\Models\LaporanRppFoto::whereIn('laporan_rpp_id', $laporanIds)->get();
                foreach ($fotos as $f) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($f->path);
                }
                \App\Models\LaporanRppFoto::whereIn('laporan_rpp_id', $laporanIds)->delete();

                // hapus data terkait laporan dan rppm
                \App\Models\LaporanRpp::where('guru_id', $id)->delete();
                \App\Models\Rppm::where('guru_id', $id)->delete();
                
                // hapus user-nya
                $user->delete();
            });
            
            return response()->json(['message' => 'User berhasil dihapus permanen']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus user: ' . $e->getMessage()], 500);
        }
    }

    public function approveReset($id)
    {
        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
                $user = User::where('id', $id)->lockForUpdate()->firstOrFail();
                
                if (!$user->reset_password_hash) {
                    return response()->json(['message' => 'Tidak ada pengajuan reset password'], 400);
                }

                $user->password = $user->reset_password_hash;
                $user->reset_code = null;
                $user->reset_password_hash = null;
                $user->save();

                return response()->json(['message' => 'Reset password disetujui']);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyetujui reset: ' . $e->getMessage()], 500);
        }
    }

    public function rejectReset($id)
    {
        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
                $user = User::where('id', $id)->lockForUpdate()->firstOrFail();
                
                if (!$user->reset_password_hash) {
                    return response()->json(['message' => 'Tidak ada pengajuan reset password'], 400);
                }
                
                $user->reset_code = null;
                $user->reset_password_hash = null;
                $user->save();

                return response()->json(['message' => 'Reset password ditolak']);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menolak reset: ' . $e->getMessage()], 500);
        }
    }
}
