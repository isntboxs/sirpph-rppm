<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('roles', 'siswa:id,nama,kelas')
            ->orderBy('name')
            ->get()
            ->map(fn (User $user) => $this->format($user));

        return response()->json(['data' => $users]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email ?? $request->username . '@sirpph.local',
            'password' => $request->password,
            'kelas' => $request->kelas,
            'hp' => $request->hp,
            'is_aktif' => true,
        ]);

        $user->syncRoles([$request->role]);

        if ($request->role === 'orang tua' && $request->siswa_ids) {
            $user->siswa()->sync($request->siswa_ids);
        }

        return response()->json([
            'message' => 'Pengguna berhasil ditambahkan.',
            'data' => $this->format($user->load('roles', 'siswa')),
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'data' => $this->format($user->load('roles', 'siswa')),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $data = $request->only(['name', 'username', 'kelas', 'hp']);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        if ($request->filled('role')) {
            $user->syncRoles([$request->role]);
        }

        if ($request->has('siswa_ids')) {
            $user->siswa()->sync($request->siswa_ids ?? []);
        }

        return response()->json([
            'message' => 'Pengguna berhasil diperbarui.',
            'data' => $this->format($user->load('roles', 'siswa')),
        ]);
    }

    public function toggleAktif(User $user): JsonResponse
    {
        if ($user->hasRole('admin')) {
            return response()->json(['message' => 'Akun admin tidak dapat dinonaktifkan.'], 403);
        }

        $user->update(['is_aktif' => ! $user->is_aktif]);

        return response()->json([
            'message' => 'Status pengguna diperbarui.',
            'is_aktif' => $user->is_aktif,
        ]);
    }

    private function format(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->getRoleNames()->first(),
            'kelas' => $user->kelas,
            'hp' => $user->hp,
            'is_aktif' => $user->is_aktif,
            'siswa' => $user->relationLoaded('siswa') ? $user->siswa : [],
        ];
    }
}
