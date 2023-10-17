<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna saat ini memiliki peran yang diizinkan
        if (Auth::check() && in_array(Auth::user()->role->name, $roles)) {
            return $next($request);
        } else {
            // Jika pengguna tidak memiliki peran yang diizinkan, redirect ke halaman lain atau tampilkan pesan error
            return redirect()->back()->with('danger', 'You do not have access to the page.');
        }
    }
}
