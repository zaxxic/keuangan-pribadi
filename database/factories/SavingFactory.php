<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Saving>
 */
class SavingFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'title' => fake()->sentence(1),
      'description' => fake()->paragraph(1),
      'target_balance' => fake()->randomNumber(8, true),
      'status' => true,
      'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id
    ];
  }
}
