<?php

namespace Database\Factories;

use App\Models\HistorySaving;
use App\Models\Saving;
use App\Models\SavingMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SavingMember>
 */
class SavingMemberFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $saving = Saving::inRandomOrder()->first();
    $user = User::where('role', 'user')->where('id', '!=', $saving->user->id)->inRandomOrder()->first();
    return [
      'user_id' => $user->id,
      'saving_id' => $saving->id
    ];
  }
}
