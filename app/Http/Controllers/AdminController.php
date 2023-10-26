<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscriber;
use App\Models\SubscriberTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
  public function index()
  {
    $users = User::where('role', 'user')->get();
    $data = [
      'usersCount' => count($users),
      'usersMonth' => count($users->filter(function ($item) {
        return Carbon::parse($item->created_at)->format("Y-m") === today()->format("Y-m");
      })),
      'usersPremium' => User::where('role', 'user')->whereHas('subscribers', function (Builder $q) {
        $q->where('status', 'active');
      })->count(),
      'last' => $this->getMonthly(today()->format('Y'), true),
      'packages' => Package::with('history')->get(),
      'total' => number_format(SubscriberTransaction::where('status', 'PAID')->sum('amount'), 0, ',', '.')
    ];

    return view('Admin.dashboard', $data);
  }

  public function paidUsers()
  {
    if (request()->ajax()) {
      $subscribers = SubscriberTransaction::join('users as u', 'subscriber_transactions.user_id', '=', 'u.id')->select('subscriber_transactions.amount', 'subscriber_transactions.status', 'subscriber_transactions.created_at as created', 'u.name', 'u.email', 'u.role')->where('role', 'user')->orderBy('created', 'DESC')->get();
      $subscribers->transform(function ($item) {
        $item->amount = 'Rp ' . number_format($item->amount, 0, ',', '.');
        $item->created = date('d M Y', strtotime($item->created));
        return $item;
      });

      return DataTables::of($subscribers)
        ->addIndexColumn()
        ->addColumn('status', function ($row) {
          $bg = ($row->status === 'PAID') ? 'success' : 'danger';
          return "<span class='badge bg-$bg-light'>{$row->status}</span>";
        })
        ->rawColumns(['status'])
        ->make();
    }
    return view('Admin.users');
  }

  public function prof(Request $request)
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

    $user = Auth::user();

    if (!Hash::check($request->input('current_password'), $user->password)) {
      return response()->json('Kata sandi saat ini salah.', 422);
    }

    // Mengganti kata sandi pengguna
    $user->password = Hash::make($request->input('new_password'));
    $user->save();

    return response()->json(['success' => 'Kata sandi berhasil diperbarui.']);
  }

  public function getMonthly($year, $last = false)
  {
    $subscribers = SubscriberTransaction::with(['user'])->where('status', 'PAID')->orderBy('created_at', 'DESC')->get();
    $data = [
      'chart' => [],
      'last' => $subscribers->slice(0, 5)
    ];

    if ($last) return $data['last'];

    $month = today()->setYear($year);
    for ($i = 1; $i <= 12; $i++) {
      $month->setMonth($i);
      array_push($data['chart'], $subscribers->filter(function ($item) use ($month) {
        $itemMonth = Carbon::parse($item->created_at)->format('Y-m');
        return $itemMonth === $month->format('Y-m');
      })->sum('amount'));
    }

    return response()->json(['data' => $data['chart']]);
  }
}
