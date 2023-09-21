<?php

namespace App\Http\Controllers;

use App\Models\HistoryTransaction;
use App\Models\Notification;
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
                    // Hitung perbedaan antara real dan count
                    $difference = $income->real - $income->count;

                    // Buat title dengan imbuhan "#" berdasarkan perbedaan
                    $title = $income->title . " #" . ($difference + 1);

                    // Buat entri dalam HistoryTransaction
                    $historyTransaction = HistoryTransaction::create([
                        'user_id' => $income->user_id,
                        'title' => $title,
                        'amount' => $income->amount,
                        'category_id' => $income->category_id,
                        'payment_method' => $income->payment_method,
                        'attachment' => $income->attachment,
                        'source' => 'reguler',
                        'content' => $income->content,
                        'description' => $income->description,
                        'date' => $today,
                    ]);

                    // Simpan perubahan tanggal pada objek RegularTransaction
                    if ($income->recurring === 'weekly') {
                        $income->date = $incomeDate->addWeek(); // Tambah 1 minggu
                    } elseif ($income->recurring === 'daily') {
                        $income->date = $incomeDate->addDay(); // Tambah 1 hari
                    } elseif ($income->recurring === 'monthly') {
                        $income->date = $incomeDate->addMonth(); // Tambah 1 bulan
                    } elseif ($income->recurring === 'yearly') {
                        $income->date = $incomeDate->addYear(); // Tambah 1 tahun
                    }

                    // Simpan perubahan tanggal pada objek RegularTransaction
                    $income->count--;
                    $income->save();

                    // Buat entri notifikasi
                    Notification::create([
                        'user_id' => $income->user_id,
                        'content' => $income->content,
                        'history_transaction_id' => $historyTransaction->id,
                    ]);
                }
            }
        }

        return "Transaksi berulang berhasil dibuat.";
    }




    // public function createExpenditureTransaction()
    // {
    //     $today = Carbon::today();

    //     // Ambil semua data pemasukan
    //     $incomes = RegularTransaction::all();

    //     foreach ($incomes as $income) {
    //         $incomeDate = Carbon::parse($income->date);

    //         if ($incomeDate->isSameDay($today)) {
    //             if ($income->count > 0) {
    //                 $historyTransaction = HistoryTransaction::create([
    //                     'user_id' => $income->user_id,
    //                     'title' => $income->title,
    //                     'amount' => $income->amount,
    //                     'category_id' => $income->category_id,
    //                     'payment_method' => $income->payment_method,
    //                     'attachment' => $income->attachment,
    //                     'content' => $income->content,
    //                     'source' => 'reguler',
    //                     'description' => $income->description,
    //                     'date' => $today,
    //                 ]);

    //                 // Kurangkan nilai count pada data pemasukan
    //                 $income->count--;

    //                 // Simpan perubahan pada objek RegularTransaction
    //                 $income->save();

    //                 if ($income->recurring === 'weekly') {
    //                     $income->date = $incomeDate->addWeek(); // Tambah 1 minggu
    //                 } elseif ($income->recurring === 'daily') {
    //                     $income->date = $incomeDate->addDay(); // Tambah 1 hari
    //                 } elseif ($income->recurring === 'monthly') {
    //                     $income->date = $incomeDate->addMonth(); // Tambah 1 bulan
    //                 } elseif ($income->recurring === 'yearly') {
    //                     $income->date = $incomeDate->addYear(); // Tambah 1 tahun
    //                 }

    //                 // Simpan perubahan tanggal
    //                 $income->save();
    //                 Notification::create([
    //                     'user_id' => $income->user_id,
    //                     'source' => 'expenditure',
    //                     'history_transaction_id' => $historyTransaction->id,
    //                 ]);
    //             }
    //         }
    //     }

    //     return "Transaksi berulang berhasil dibuat.";
    // }
}
