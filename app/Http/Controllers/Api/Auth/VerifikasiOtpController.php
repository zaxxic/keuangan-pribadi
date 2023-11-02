<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Verified;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VerifikasiOtpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|string|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid verification code format.'], 422);
        }

        $user = $request->user(); // Mengambil pengguna yang sudah terotentikasi

        if (strcmp($user->verification_code, $request->input('verification_code')) === 0) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();

            return response()->json(['message' => 'Email verification successful.'], 200);
        } else {
            return response()->json(['message' => 'Invalid verification code. Please check your email.'], 400);
        }
    }
    public function verifyIndex()
    {
        return view('auth.verifikasi');
        // dd('asd');
    }
    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $currentTime = now();
            $lastVerificationSentTime = $user->last_verification_request_time;

            if ($lastVerificationSentTime) {
                $timeDifference = $currentTime->diffInMinutes($lastVerificationSentTime);

                if ($timeDifference < 3) {
                    return response()->json(['message' => 'Anda hanya dapat meminta ulang kode verifikasi sekali setiap 3 menit.'], 400);
                }
            }

            $newVerificationCode = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

            $user->verification_code = $newVerificationCode;
            $user->last_verification_request_time = $currentTime;
            $user->save();

            Mail::to($user->email)->queue(new Verified($newVerificationCode));

            return response()->json(['message' => 'Email Verifikasi berhasil di kirim.'], 200);
        }

        return response()->json(['message' => 'Autentikasi gagal.'], 401);
    }
}
