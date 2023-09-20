<?php

namespace App\Http\Controllers;

use App\Models\HistoryTransaction;
use App\Models\RegularTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{


    public function createRecurringTransactions()
    {
        $today = Carbon::today();

        // Ambil semua data pemasukan
        $incomes = RegularTransaction::all();

        foreach ($incomes as $income) {
            $incomeDate = Carbon::parse($income->date);

            if ($incomeDate->isSameDay($today)) {
                if ($income->count > 0) {
                    HistoryTransaction::create([
                        'user_id' => $income->user_id,
                        'title' => $income->title,
                        'amount' => $income->amount,
                        'category_id' => $income->category_id,
                        'payment_method' => $income->payment_method,
                        'attachment' => $income->attachment,
                        'content' => $income->content,
                        'description' => $income->description,
                        'date' => $today,
                    ]);

                    // Kurangkan nilai count pada data pemasukan
                    $income->count--;
                    $income->save();
                }
            }
        }

        return "Transaksi berulang berhasil dibuat.";
    }
}
