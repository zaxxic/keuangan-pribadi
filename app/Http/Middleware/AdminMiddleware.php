<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin' && Auth::user()->email_verified_at !== null) {
            // Jika pengguna adalah admin dan email telah diverifikasi, lanjutkan ke halaman yang diminta
            return $next($request);
        } elseif (!Auth::check()) {
            return redirect('/login');
        } elseif (Auth::check() && Auth::user()->email_verified_at === null) {
            return redirect('/email/verify');
        } else {    
            return redirect('/home');
        }

        abort(403, 'Unauthorized');
    }
}
