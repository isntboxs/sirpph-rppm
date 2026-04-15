<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationHandler
{
    public function handle(Request $request, Closure $next)
    {
        // Simpel cek sudah login atau belum
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
