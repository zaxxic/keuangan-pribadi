<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request);
        } elseif (!Auth::check()) {
            if($request->get('id') && $request->get('key')){
              Session::put('saving_id', $request->get('id'));
              Session::put('saving_key', $request->get('key'));
              return redirect("/login");
            }
            return redirect('/login');
        }

        abort(403, 'Unauthorized');
    }
}
