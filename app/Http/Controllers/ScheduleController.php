<?php

namespace App\Http\Controllers;

use App\Mail\ExpireSubscriber;
use App\Mail\TransactionNotification;
use App\Models\Category;
use App\Models\HistoryTransaction;
use App\Models\Notification;
use App\Models\RegularTransaction;
use App\Models\Saving;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
  public function createRecurringSavings()
  {
    $today = Carbon::today();

    $savings = Saving::where('status', true)->with(['user', 'histories' => function ($q) {
      $q->withSum('history', 'amount');
    }])->get();

    $category = Category::where('name', 'Tabungan')->first();

    foreach ($savings as $saving) {
      $savingDate = Carbon::parse($saving->regular->date);

      if ($savingDate->isSameDay($today)) {
        $total = $saving->histories->sum('history_sum_amount');
        if ($saving->regular->amount * (count($saving->members) + 1) <= $saving->target_balance - $total) {
          $title = $saving->title . ' #' . $saving->regular->count + 1;
          $members = collect([$saving->user, $saving->members])->flatten(1);

          foreach ($members as $member) {
            $history = HistoryTransaction::create([
              'user_id' => $member->id,
              'title' => $title,
              'amount' => $saving->regular->amount,
              'category_id' => $category->id,
              'payment_method' => $saving->regular->payment_method,
              'attachment' => 'default.jpg',
              'source' => 'tabungan',
              'status' => 'pending',
              'content' => 'expenditure',
              'description' => $saving->description,
              'date' => $today,
            ]);

            $history->hasSaving()->create([
              'saving_id' => $saving->id
            ]);

            Notification::create([
              'user_id' => $member->id,
              'content' => 'expenditure',
              'status' => 'aktif',
              'history_transaction_id' => $history->id,
            ]);
          }

          if ($saving->regular->recurring === 'week') {
            $saving->regular->date = $savingDate->addWeek(); // Tambah 1 minggu
          } elseif ($saving->regular->recurring === 'month') {
            $saving->regular->date = $savingDate->addMonth(); // Tambah 1 bulan
          } elseif ($saving->regular->recurring === 'year') {
            $saving->regular->date = $savingDate->addYear(); // Tambah 1 tahun
          }

          $saving->regular->count++;
          $saving->save();
          $saving->regular->save();
        }
      }
    }
  }

  public function createRecurringTransactions()
  {
    $today = Carbon::today();

    // Ambil semua data pemasukan
    $incomes = RegularTransaction::all();

    foreach ($incomes as $income) {
      $incomeDate = Carbon::parse($income->date);

      if ($incomeDate->isSameDay($today)) {
        if ($income->count > 0) {
          $difference = $income->real - $income->count;

          $title = $income->title . " #" . ($difference + 1);

          $historyTransaction = HistoryTransaction::create([
            'user_id' => $income->user_id,
            'title' => $title,
            'amount' => $income->amount,
            'category_id' => $income->category_id,
            'payment_method' => $income->payment_method,
            'attachment' => $income->attachment,
            'source' => 'reguler',
            'status' => 'pending',
            'content' => $income->content,
            'description' => $income->description,
            'date' => $today,
          ]);

          if ($income->recurring === 'weekly') {
            $income->date = $incomeDate->addWeek(); // Tambah 1 minggu
          } elseif ($income->recurring === 'daily') {
            $income->date = $incomeDate->addDay(); // Tambah 1 hari
          } elseif ($income->recurring === 'monthly') {
            $income->date = $incomeDate->addMonth(); // Tambah 1 bulan
          } elseif ($income->recurring === 'yearly') {
            $income->date = $incomeDate->addYear(); // Tambah 1 tahun
          }

          $income->count--;
          $income->save();

          Notification::create([
            'user_id' => $income->user_id,
            'content' => $income->content,
            'status' => 'aktif',
            'history_transaction_id' => $historyTransaction->id,
          ]);

          if (!empty($income->content)) {

            Mail::to($income->user->email, $income->amount, $income->user->name)->send(new TransactionNotification($income->content, $income->amount, $income->user->name));
          }
        }
      }
    }

    return "Transaksi berulang berhasil dibuat.";
  }

  public function expire()
  {
    $expiredSubscribers = Subscriber::where('status', 'active')
      ->where('expire_date', '<', Carbon::now())
      ->get();

    foreach ($expiredSubscribers as $subscriber) {
      $subscriber->status = 'off';
      $subscriber->save();
    }
    return "non aktif subscriber.";
  }

  public function lastExpire()
  {
    $upcomingExpirySubscribers = Subscriber::where('status', 'active')
      ->where('expire_date', '>', Carbon::now())
      ->where('expire_date', '<', Carbon::now()->addWeek()) // Kurang dari satu minggu dari sekarang
      ->get();

    foreach ($upcomingExpirySubscribers as $subscriber) {
      // Kirim email notifikasi ke pelanggan
        Mail::to($subscriber->user->email)->send(new ExpireSubscriber($subscriber));


    }

    return "Email notifikasi dikirim kepada pelanggan yang akan segera berakhir langganan.";
  }
}
