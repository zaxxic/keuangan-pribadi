<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoryTransaction;
use App\Models\SubscriberTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TotalController extends Controller
{
    public function total()
    {
        $filtered = json_decode($this->filterTotal(today()->format("Y-m")), true);
        $data = [
            'filtered' => $filtered
        ];

        return response()->json($data);
    }

    // public function export($bulan)
    // {
    //     return Excel::download(new HistoriesExport(Auth::user()->id, $bulan), "$bulan.xlsx");
    // }


    public function pembelian(Request $request)
    {
        try {
            $subscribers = SubscriberTransaction::where('user_id', Auth::user()->id)
                ->join('packages as p', 'subscriber_transactions.package_id', '=', 'p.id')
                ->select('subscriber_transactions.amount', 'subscriber_transactions.created_at as created', 'subscriber_transactions.status as status', 'p.title as title')
                ->orderBy('created', 'DESC')
                ->get();

            $subscribers->transform(function ($item) {
                $item->amount = 'Rp ' . number_format($item->amount, 0, ',', '.');
                $item->created = date('d M Y', strtotime($item->created));
                return $item;
            });

            return response()->json([
                'status' => true,
                'message' => 'Data transaksi pembelian ditemukan.',
                'data' => $subscribers
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data transaksi pembelian.',
                'error' => $th->getMessage()
            ], 500);
        }
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
}
