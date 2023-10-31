<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirectGoogle()
    {
        
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $user_google    = Socialite::driver('google')->user();
            $user           = User::where('email', $user_google->getEmail())->first();


            if ($user != null) {
                \auth()->login($user, true);
                return redirect()->route('home');
            } else {
                $create = User::Create([
                    'email'             => $user_google->getEmail(),
                    'name'              => $user_google->getName(),
                    'password'          => 0,
                    'email_verified_at' => now()
                ]);


                // \auth()->login($create, true);

                return redirect()->route('login')->with('message', 'Gmail berhasil terdafar, Silakan login melalui Gmail yang sudah di daftarkan');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Email yang anda pilih');
        }
    }
    public function redirectFacebook()
    {
        // $clientId = config('facebook.client_id');
        // dd($clientId);
        return  Socialite::driver('facebook')->redirect();
        // $user_google    = Socialite::driver('facebook')->user();
        // dd($user_google);
    }

    public function facebookCallback()
    {
        try {
            dd('asdasd');

            $user = Socialite::driver('facebook')->user();
            dd($user);

            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => encrypt('Test123456')
                ]);

                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
