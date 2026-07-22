<?php

namespace App\Http\Controllers;

use App\Models\DataSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('beranda');
        }
        $sekolah = DataSekolah::getData();
        return view('auth.login', compact('sekolah'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'active'   => 1,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return match (Auth::user()->role) {
                'admin'  => redirect()->route('beranda'),
                'kepala' => redirect()->route('beranda'),
                'guru'   => redirect()->route('beranda'),
                'ortu'   => redirect()->route('beranda'),
                default  => redirect()->route('beranda'),
            };
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function requestReset(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password_baru' => 'required|string|min:4'
        ], [
            'username.required' => 'Username wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 4 karakter.'
        ]);

        $code = strtoupper(\Illuminate\Support\Str::random(5));

        $user = \App\Models\User::where('username', $request->username)->first();

        if ($user) {
            $user->reset_code = $code;
            $user->reset_password_hash = \Illuminate\Support\Facades\Hash::make($request->password_baru);
            $user->save();

            $admins = \App\Models\User::where('role', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\PasswordResetNotification($user->name, $user->id, $code));
        }

        return response()->json([
            'status' => true,
            'message' => 'Permintaan reset berhasil.',
            'code' => $code
        ]);
    }
}
