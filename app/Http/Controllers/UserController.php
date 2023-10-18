<?php

namespace App\Http\Controllers;

use App\Exports\HistoriesExport;
use App\Models\HistoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\Verified;
use App\Models\Saving;
use App\Models\SubscriberTransaction;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $histories = HistoryTransaction::where('user_id', $user->id)->where('status', 'paid')->orderBy('created_at', 'DESC')->get();
    $data = [
      'user' => $user,
      // 'expenditures' => HistoryTransaction::where('user_id', $user->id)->where('content', 'expenditure')->where('status', 'paid')->orderBy('created_at', 'DESC')->limit(5)->get(),
      // 'incomes' => HistoryTransaction::where('user_id', $user->id)->where('content', 'income')->where('status', 'paid')->orderBy('created_at', 'DESC')->limit(5)->get(),
      'chartData' => $this->filterDashboard(),
      'exAmount' => $histories->filter(fn ($item) => $item->content === 'expenditure')->sum('amount'),
      'inAmount' => $histories->filter(fn ($item) => $item->content === 'income')->sum('amount'),
      'exCount' => count($histories->filter(fn ($item) => $item->content === 'expenditure')),
      'inCount' => count($histories->filter(fn ($item) => $item->content === 'income')),
      'expenditures' => $histories->filter(fn ($item) => $item->content === 'expenditure')->slice(0, 5),
      'incomes' => $histories->filter(fn ($item) => $item->content === 'income')->slice(0, 5),
      // 'chartData' => $this->filterDashboard($histories)
    ];

    return view('User.dashboard', $data);
  }

  function indexVerify()
  {
    return view('auth.verifikasi');
  }

  public function verify(Request $request)
  {
    $user = auth()->user();

    $verificationCode = $request->input('verification_code');


    if ($user && strcmp($user->verification_code, $verificationCode) === 0) {
      $user->email_verified_at = now();
      $user->verification_code = null;

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

        if ($timeDifference < 3) {
          return redirect()->back()->with('error', 'Anda hanya dapat meminta ulang kode verifikasi sekali setiap 3 menit.');
        }
      }

      $newVerificationCode = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

      $user->verification_code = $newVerificationCode;

      $user->last_verification_request_time = $currentTime;

      $user->save();

      Mail::to($user->email)->queue(new Verified($newVerificationCode));


      return redirect()->back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    return redirect()->route('login');
  }


  public function total()
  {
    $filtered = json_decode($this->filterTotal(today()->format("Y-m")), true);
    $data = [
      'filtered' => $filtered
    ];
    return view("User.menu.total", $data);
  }

  public function export($bulan)
  {
    return Excel::download(new HistoriesExport(Auth::user()->id, $bulan), "$bulan.xlsx");
  }

  public function pembelian()
  {
    if (request()->ajax()) {

      $subscribers = SubscriberTransaction::where('user_id', Auth::user()->id)->join('packages as p', 'subscriber_transactions.package_id', '=', 'p.id')->select('subscriber_transactions.amount', 'subscriber_transactions.created_at as created', 'p.title as title')->orderBy('created', 'DESC')->get();
      $subscribers->transform(function ($item) {
        $item->amount = 'Rp ' . number_format($item->amount, 0, ',', '.');
        $item->created = date('d M Y', strtotime($item->created));
        return $item;
      });
      return DataTables::of($subscribers)
        ->addIndexColumn()
        // ->addColumn('status', function ($row) {
        //   $bg = ($row->status === 'active') ? 'success' : 'danger';
        //   return "<span class='badge bg-$bg-light'>{$row->status}</span>";
        // })
        // ->rawColumns(['status'])
        ->make();
    }
    return view('User.menu.pembelian');
  }

  public function filterTotal($month)
  {
    $day = Carbon::parse($month)->locale('id');
    $day->settings(['formatFunction' => 'translatedFormat']);
    $formatDay = $day->format("Y-m");
    $before = Carbon::parse($month)->locale('id')->addMonths(-1);
    $before->settings(['formatFunction' => 'translatedFormat']);
    $histories = HistoryTransaction::where('user_id', Auth::user()->id)->where('status', 'paid')->where(function ($q) use ($day, $before) {
      $q->where('date', 'like', "{$day->format('Y-m')}%")->orWhere('date', 'like', "{$before->format('Y-m')}%");
    })->get();
    $incomes = $histories->filter(function ($history) use ($formatDay) {
      $historyDate = Carbon::parse($history->date);
      return $history->content === 'income' && $historyDate->format("Y-m") === $formatDay;
    });
    $expenditures = $histories->filter(function ($history) use ($formatDay) {
      $historyDate = Carbon::parse($history->date);
      return $history->content === 'expenditure' && $historyDate->format("Y-m") === $formatDay;
    });
    $totalBefore = $histories->filter(function ($history) use ($before) {
      $historyDate = Carbon::parse($history->date);
      return $history->content === 'income' && $historyDate->format("Y-m") === $before->format("Y-m");
    })->sum("amount") - $histories->filter(function ($history) use ($before) {
      $historyDate = Carbon::parse($history->date);
      return $history->content === 'expenditure' && $historyDate->format("Y-m") === $before->format("Y-m");
    })->sum("amount");
    $data = [
      'chart' => [
        'days' => [],
        'pemasukan' => [],
        'pengeluaran' => []
      ],
      'tulisan' => [
        'pemasukan' => $incomes->sum("amount"),
        'pengeluaran' => $expenditures->sum("amount"),
        'before' => $totalBefore,
        'thisMonth' => $day->format("M"),
        'beforeMonth' => $before->format("M")
      ],
      'incomes' => $incomes->toArray(),
      'expenditures' => $expenditures->toArray()
    ];

    for ($i = 1; $i <= $day->daysInMonth; $i++) {
      $day->setDay($i);
      array_push($data['chart']['days'], $i);

      array_push($data['chart']['pemasukan'], $incomes->filter(function ($history) use ($day) {
        $historyDate = Carbon::parse($history->date);
        return $historyDate->eq($day);
      })->sum('amount'));

      array_push($data['chart']['pengeluaran'], $expenditures->filter(function ($history) use ($day) {
        $historyDate = Carbon::parse($history->date);
        return $historyDate->eq($day);
      })->sum('amount'));
    }
    return json_encode($data);
  }

  protected function filterDashboard()
  {
    $data = [
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

    $histories = HistoryTransaction::where('user_id', Auth::user()->id)->where('status', 'paid')->orderBy('created_at', 'DESC')->get();

    $today = Carbon::today()->locale('id');
    $today->settings(['formatFunction' => 'translatedFormat']);

    for ($i = 6; $i >= 0; $i--) {
      $now = Carbon::parse($today);
      $date = $now->setDay($now->day - $i);

      $day = $date->format('l');
      array_push($data['daily']['labels'], $day);

      array_push($data['daily']['received'], $histories->filter(function ($item) use ($date) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->eq($date) && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['daily']['pending'], $histories->filter(function ($item) use ($date) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->eq($date) && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));
    }

    for ($i = 1, $start = Carbon::parse($today)->firstOfMonth(); $i <= 4; $i++) {
      $end = Carbon::parse($start)->addWeek()->addDays(-1);
      if ($i === 4) $end = $end->lastOfMonth();

      array_push($data['weekly']['labels'], "Minggu ke $i");

      array_push($data['weekly']['received'], $histories->filter(function ($item) use ($start, $end) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->gte($start) && $itemDate->lte($end) && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['weekly']['pending'], $histories->filter(function ($item) use ($start, $end) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->gte($start) && $itemDate->lte($end) && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));

      $start->addWeek();
    }

    for ($i = 1; $i <= 12; $i++) {
      $month = Carbon::parse($today)->setMonth($i);
      array_push($data['monthly']['labels'], $month->format('M'));

      array_push($data['monthly']['received'], $histories->filter(function ($item) use ($i) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->month === $i && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['monthly']['pending'], $histories->filter(function ($item) use ($i) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->month === $i && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));
    }

    for ($i = 3; $i >= 0; $i--) {
      $year = Carbon::parse($today)->setYear($today->year - $i);
      array_push($data['yearly']['labels'], $year->format('Y'));

      array_push($data['yearly']['received'], $histories->filter(function ($item) use ($year) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->year === $year->year && $item->content === 'income' && $item->status === 'paid';
      })->sum('amount'));

      array_push($data['yearly']['pending'], $histories->filter(function ($item) use ($year) {
        $itemDate = Carbon::parse($item->date);
        return $itemDate->year === $year->year && $item->content === 'expenditure' && $item->status === 'paid';
      })->sum('amount'));
    }

    return $data;
  }
}
