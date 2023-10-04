<?php

namespace App\Http\Controllers;

use App\Exports\HistoriesExport;
use App\Models\HistoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\Verified;
use Carbon\Carbon;

class UserController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $data = [
      'user' => $user,
      'expenditures' => HistoryTransaction::where('user_id', $user->id)->where('content', 'expenditure')->orderBy('date', 'DESC')->limit(5)->get(),
      'incomes' => HistoryTransaction::where('user_id', $user->id)->where('content', 'income')->orderBy('date', 'DESC')->limit(5)->get(),
    ];
    return view('User.dashboard', $data);
  }

  function indexVerify()
  {
    return view('auth.verifikasi');
  }

  public function verify(Request $request)
  {
    $user = auth()->user(); // Dapatkan pengguna yang saat ini masuk

    $verificationCode = $request->input('verification_code');
    // dd('Verification Code: [' . $verificationCode . ']', 'User Code: [' . $user->verification_code . ']');


    // dd($verificationCode, $user->verification_code);
    if ($user && strcmp($user->verification_code, $verificationCode) === 0) {
      $user->email_verified_at = now(); // Atur waktu verifikasi
      $user->verification_code = null; // Hapus kode verifikasi

      $user->save();

      return redirect()->route('home');
    } else {
      return redirect()->back()->with('message', 'Kode tidak valid silahkan check email.');
    }
  }

  public function resend()
  {
    $user = auth()->user();

    if ($user) {
      $currentTime = now();
      $lastVerificationSentTime = $user->last_verification_request_time;

      if ($lastVerificationSentTime) {
        $timeDifference = $currentTime->diffInMinutes($lastVerificationSentTime);

        // Cek apakah sudah melewati 3 menit sejak pengiriman kode verifikasi terakhir
        if ($timeDifference < 3) {
          return redirect()->back()->with('error', 'Anda hanya dapat meminta ulang kode verifikasi sekali setiap 3 menit.');
        }
      }

      // Generate kode verifikasi baru
      $newVerificationCode = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

      // Simpan kode verifikasi baru
      $user->verification_code = $newVerificationCode;

      // Simpan timestamp waktu terakhir kali pengiriman kode verifikasi
      $user->last_verification_request_time = $currentTime;

      // Simpan perubahan
      $user->save();

      // Kirim email
      Mail::to($user->email)->queue(new Verified($newVerificationCode));


      return redirect()->back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    return redirect()->route('login');
  }


  public function getHistory()
  {
    return json_encode(HistoryTransaction::where('user_id', Auth::user()->id)->orderBy('date', 'DESC')->get());
  }

  public function export($bulan)
  {
    return Excel::download(new HistoriesExport(Auth::user()->id, $bulan), "$bulan.xlsx");
  }
}
