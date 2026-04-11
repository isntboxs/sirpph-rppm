<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('beranda');
        }
        return view('pages.login.index');
    }

    /**
     * Proses login.
     * akun hardcoded.
     * Ganti pake Auth::attempt() jika sudah ada tabel users.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Demo credentials, ganti dengan Auth::attempt() tunggu tabel users
        $demoAccounts = [
            'admin'  => ['password' => 'admin123', 'role' => 'Admin'],
            'kepala' => ['password' => 'kepala123', 'role' => 'Kepala Sekolah'],
            'guru_a' => ['password' => 'guru123',  'role' => 'Guru'],
            'guru_b' => ['password' => 'guru123',  'role' => 'Guru'],
            'ortu1'  => ['password' => 'ortu123',  'role' => 'Orang Tua'],
        ];

        $username = $request->input('username');
        $password = $request->input('password');

        if (isset($demoAccounts[$username]) && $demoAccounts[$username]['password'] === $password) {
            // Create Session
            session([
                'demo_user'     => $username,
                'demo_role'     => $demoAccounts[$username]['role'],
                'logged_in' => true,
            ]);
            return redirect()->route('beranda');
        }

        return back()
            ->withInput($request->only('username', 'role'))
            ->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
