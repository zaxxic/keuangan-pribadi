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
    $histories = HistoryTransaction::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
    $data = [
      'user' => $user,
      'expenditures' => $histories->filter(function ($item) {
        return $item->content === 'expenditure';
      }),
      'incomes' => $histories->filter(function ($item) {
        return $item->content === 'income';
      }),
    ];
    $data['chartData'] = [
      'daily' => [
        'labels' => [],
        'received' => [],
        'pending' => [],
      ],
      'weekly' => [
        'labels' => [],
        'received' => [],
        'pending' => [],
      ],
      'monthly' => [
        'labels' => [],
        'received' => [],
        'pending' => [],
      ],
      'yearly' => [
        'labels' => [],
        'received' => [],
        'pending' => [],
      ],
    ];

    $today = Carbon::today()->locale('id');
    $today->settings(['formatFunction' => 'translatedFormat']);

    for ($i = 6; $i >= 0; $i--) {
      $now = Carbon::parse($today);
      $date = $now->setDay($now->day - $i);

      $day = $date->format('l');
      array_push($data['chartData']['daily']['labels'], $day);

      array_push($data['chartData']['daily']['received'], $histories->filter(function ($item) use ($date) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->eq($date) && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['chartData']['daily']['pending'], $histories->filter(function ($item) use ($date) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->eq($date) && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));
    }

    for ($i = 1, $start = Carbon::parse($today)->firstOfMonth(); $i <= 4; $i++) {
      $end = Carbon::parse($start)->addWeek()->addDays(-1);
      if ($i === 4) $end = $end->lastOfMonth();

      array_push($data['chartData']['weekly']['labels'], "Minggu ke $i");

      array_push($data['chartData']['weekly']['received'], $histories->filter(function ($item) use ($start, $end) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->gte($start) && $itemDate->lte($end) && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['chartData']['weekly']['pending'], $histories->filter(function ($item) use ($start, $end) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->gte($start) && $itemDate->lte($end) && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));

      $start->addWeek();
    }

    for ($i = 1; $i <= 12; $i++) {
      $month = Carbon::parse($today)->setMonth($i);
      array_push($data['chartData']['monthly']['labels'], $month->format('M'));

      array_push($data['chartData']['monthly']['received'], $histories->filter(function ($item) use ($i) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->month === $i && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['chartData']['monthly']['pending'], $histories->filter(function ($item) use ($i) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->month === $i && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));
    }

    for ($i = 3; $i >= 0; $i--) {
      $year = Carbon::parse($today)->setYear($today->year - $i);
      array_push($data['chartData']['yearly']['labels'], $year->format('Y'));

      array_push($data['chartData']['yearly']['received'], $histories->filter(function ($item) use ($year) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->year === $year->year && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['chartData']['yearly']['pending'], $histories->filter(function ($item) use ($year) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->year === $year->year && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));
    }

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
    return json_encode(HistoryTransaction::where('user_id', Auth::user()->id)->where('status', 'paid')->orderBy('date', 'DESC')->get());
  }

  public function export($bulan)
  {
    return Excel::download(new HistoriesExport(Auth::user()->id, $bulan), "$bulan.xlsx");
  }
}
