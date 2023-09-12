<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    function index()
    {
        $user = Auth::user();
        return view('User.menu.settings', compact('user'));
    }

    public function update(Request $request)
    {
        // Aturan validasi
        $rules = [
            'email' => 'required|email',
            'gender' => 'in:male,female',
            'birthday' => 'date',
            'image' => 'image|mimes:jpeg,png,jpg|max:5120',
        ];

        // Pesan kustom untuk pesan kesalahan validasi
        $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'gender.in' => 'Pilih salah satu jenis kelamin yang tersedia.',
            'birthday.date' => 'Format tanggal ulang tahun tidak valid.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'File gambar harus memiliki format: jpeg, png dan jpg.',
            'image.max' => 'File gambar tidak boleh lebih dari 5MB.',
        ];

        // Validasi data yang masuk
        $validator = Validator::make($request->all(), $rules, $messages);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        // Mengambil data pengguna yang sedang masuk
        $user = Auth::user();

        // Update informasi pribadi pengguna
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->birthday = $request->input('birthday');

        // Upload dan simpan gambar profil jika ada
        if ($request->hasFile('image')) {
            if ($user->image !== 'default.jpg') {
                Storage::delete('public/profile/' . $user->image);
            }

            // Menyimpan gambar yang baru diunggah
            $imagePath = $request->file('image')->store('public/profile');
            $user->image = basename($imagePath);
        }

        $user->save();

        // Mengembalikan respons JSON yang sesuai
        return response()->json(['success' => 'Informasi pribadi berhasil diperbarui.']);
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ];

        $messages = [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.string' => 'Kata sandi baru harus berupa teks.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ];

        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }


        // Mengambil pengguna yang sedang masuk
        $user = Auth::user();

        // Memeriksa apakah kata sandi saat ini cocok
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json('Kata sandi saat ini salah.', 422);
        }

        // Mengganti kata sandi pengguna
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['success' => 'Kata sandi berhasil diperbarui.']);
    }
}
