<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserApi
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
                return response()->json(['message' => 'Admins are not allowed to access this endpoint.'], 403);
            }

            // Check if the user is a 'user' role and has not verified their email
            if ($user->role === 'user' && $user->email_verified_at === null) {
                // return response()->json(['message' => 'User email not verified.'], 403);
                return redirect('api/email/verify');
            }


            return $next($request);
        } else if (!Auth::check()) {
            if ($request->get('id') && $request->get('key')) {
                // You can handle the logic for saving_id and saving_key here if needed
                return response()->json(['message' => 'Authentication required.'], 401);
            }
        }

        return response()->json(['message' => 'Authentication required.'], 401);
    }
}
