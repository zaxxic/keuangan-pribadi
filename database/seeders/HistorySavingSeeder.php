<?php

namespace Database\Seeders;

use App\Models\HistorySaving;
use App\Models\HistoryTransaction;
use App\Models\Saving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorySavingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    for ($i = 0; $i < 50; $i++) {
      $saving = Saving::inRandomOrder()->first();
      $histories = HistorySaving::where('saving_id', $saving->id)->get()->toArray();
      $transactions = [];
      foreach ($histories as $history) {
        $transactions[] = $history['history_transaction_id'];
      }
      $historyTransaction = HistoryTransaction::where('content', 'expenditure')->whereNotIn('id', $transactions)->inRandomOrder()->first();
      if ($historyTransaction) {
        HistorySaving::create([
          'saving_id' => $saving->id,
          'history_transaction_id' => $historyTransaction->id
        ]);
      }
    }
  }
}
