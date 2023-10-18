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
    if (Auth::check()) {
      $user = Auth::user();
      if ($user->role === 'admin') {
        return redirect('admin');
      }

      // Check if the user is a 'user' role and has not verified their email
      if ($user->role === 'user' && $user->email_verified_at === null) {
        return redirect('email/verify');
      }

      return $next($request);
    } else if (!Auth::check()) {
      if ($request->get('id') && $request->get('key')) {
        Session::put('saving_id', $request->get('id'));
        Session::put('saving_key', $request->get('key'));
        return redirect("/login");
      }
    }

    return redirect('/login');
  }
}
