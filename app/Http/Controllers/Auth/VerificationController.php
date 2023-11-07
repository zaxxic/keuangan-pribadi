<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    // public function verify(Request $request)
    // {
     //     if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
    //         return redirect('/login')->with('error', 'URL verifikasi tidak valid.');
    //     }

     //     if ($request->user()->hasVerifiedEmail()) {
    //         // Pengguna sudah memverifikasi alamat email mereka, Anda dapat mengarahkan pengguna atau memberikan pesan sesuai kebutuhan Anda
    //         return redirect('/dashboard')->with('info', 'Alamat email sudah diverifikasi sebelumnya.');
    //     }

     //     if ($request->user()->markEmailAsVerified()) {
    //         // Email berhasil diverifikasi, Anda dapat memicu event Verified jika perlu
    //         event(new Verified($request->user()));

    //         // Anda dapat mengarahkan pengguna atau memberikan pesan sesuai kebutuhan Anda
    //         return redirect('/dashboard')->with('success', 'Alamat email berhasil diverifikasi.');
    //     } else {
    //         // Verifikasi email gagal, Anda dapat menangani kesalahan ini sesuai kebutuhan Anda
    //         return redirect('/login')->with('error', 'Gagal verifikasi alamat email.');
    //     }
    // }

}
