<?php

namespace Database\Seeders;

use App\Models\RegularSaving;
use App\Models\Saving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegularSavingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $savings = Saving::get();
    $method = [null, 'Cash', 'Kredit', 'E-Wallet'];
    $recurring = ['week', 'month', 'year'];

    foreach ($savings as $saving) {
      RegularSaving::create([
        'amount' => fake()->randomNumber(5, true),
        'payment_method' => $method[array_rand($method, 1)],
        'recurring' => $recurring[array_rand($recurring, 1)],
        'date' => fake()->dateTimeInInterval('+ 1 week', '+4 weeks'),
        'saving_id' => $saving->id
      ]);
    }
  }
}
