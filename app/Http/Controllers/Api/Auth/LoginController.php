<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validasi error',
                    'errors' => $validate->errors()
                ], 422);
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email atau password salah.',
                ], 422);
            }
            $user = User::where('email', $request->email)->first();
            $customData = [
                "name" => $user["name"],
                "email" => $user["email"],
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ];
            return response()->json([
                'status' => true,
                'message' => 'anda berhasil login',
                'data' => $customData
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke semua token akses personal pengguna
            $request->user()->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json([
                'status' => true,
                'message' => 'Anda telah berhasil logout.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
