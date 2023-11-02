<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoryTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $histories = HistoryTransaction::where('user_id', $user->id)
                ->where('status', 'paid')
                ->orderBy('created_at', 'DESC')
                ->get();

            $data = [
                'user' => $user,
                'exAmount' => $histories->filter(fn ($item) => $item->content === 'expenditure')->sum('amount'),
                'inAmount' => $histories->filter(fn ($item) => $item->content === 'income')->sum('amount'),
                'exCount' => count($histories->filter(fn ($item) => $item->content === 'expenditure')),
                'inCount' => count($histories->filter(fn ($item) => $item->content === 'income')),
                'expenditures' => $histories->filter(fn ($item) => $item->content === 'expenditure')->slice(0, 5),
                'incomes' => $histories->filter(fn ($item) => $item->content === 'income')->slice(0, 5),
                'chartData' => $this->filterDashboard($histories),
            ];

            return response()->json([
                'status' => true,
                'message' => 'Data dashboard ditemukan.',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data dashboard.',
                'error' => $th->getMessage()
            ], 500);
        }
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
