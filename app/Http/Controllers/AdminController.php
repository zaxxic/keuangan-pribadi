<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

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
      'last' => $this->getMonthly(today()->format('Y'), true)
    ];
    return view('Admin.dashboard', $data);
  }

  public function paidUsers()
  {
    if (request()->ajax()) {

      $subscribers = Subscriber::join('users as u', 'subscribers.user_id', '=', 'u.id')->select('subscribers.expire_date', 'subscribers.amount', 'subscribers.status', 'subscribers.created_at as created', 'u.name', 'u.email', 'u.role')->where('role', 'user')->orderBy('created', 'DESC')->get();
      $subscribers->transform(function ($item) {
        $item->amount = 'Rp ' . number_format($item->amount, 0, ',', '.');
        $item->created = date('d M Y', strtotime($item->created));
        $item->expire_date = date('d M Y', strtotime($item->expire_date));
        return $item;
      });
      return DataTables::of($subscribers)
        ->addIndexColumn()
        ->addColumn('status', function ($row) {
          $bg = ($row->status === 'active') ? 'success' : 'danger';
          return "<span class='badge bg-$bg-light'>{$row->status}</span>";
        })
        ->rawColumns(['status'])
        ->make();
    }
    return view('Admin.users');
  }

  public function getMonthly($year, $last = false)
  {
    $subscribers = Subscriber::with(['user'])->orderBy('created_at', 'DESC')->get();
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

    return json_encode($data['chart']);
  }
}
