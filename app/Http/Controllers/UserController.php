<?php

namespace App\Http\Controllers;

use App\Models\HistoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
  public function getHistory()
  {
    return json_encode(HistoryTransaction::where('user_id', Auth::user()->id)->get());
  }
}
