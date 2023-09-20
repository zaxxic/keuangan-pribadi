<?php

namespace App\Http\Controllers;

use App\Exports\HistoriesExport;
use App\Models\HistoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
    return json_encode(HistoryTransaction::where('user_id', Auth::user()->id)->orderBy('date', 'DESC')->get());
  }

  public function export($bulan){
    return Excel::download(new HistoriesExport(Auth::user()->id, $bulan), "$bulan.xlsx");
  }
}
