<?php

namespace Database\Factories;

use App\Models\HistorySaving;
use App\Models\HistoryTransaction;
use App\Models\Saving;
use App\Models\SavingMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistorySaving>
 */
class HistorySavingFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $saving = Saving::inRandomOrder()->first();
    $history = HistoryTransaction::where('content', 'expenditure')->inRandomOrder()->first();
    return [
      'saving_id' => $saving->id,
      'history_transaction_id' => $history->id
    ];
  }
}
