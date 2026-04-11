<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth
{
    public function handle(Request $request, Closure $next)
    {
        // Just simple login check
        // Jika ada tabel user, cek role dari db/session (simple Auth)
        if (!session('logged_in')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
