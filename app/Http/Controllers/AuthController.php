<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Rpph;
use App\Models\Rppm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('beranda');
        }
        return view('auth.login');
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

            if (Auth::user()->role === 'kepala') {
                $rppm_count     = Rppm::pending()->count();
                $rpph_count     = Rpph::pending()->count();
                $kegiatan_count = Kegiatan::pending()->count();
                session([
                    'rppm_count' => $rppm_count,
                    'rpph_count' => $rpph_count,
                    'kegiatan_count' => $kegiatan_count,
                ]);
            }
            return redirect()->intended(route('beranda'));
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
}
