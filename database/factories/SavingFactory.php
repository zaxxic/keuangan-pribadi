<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
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
      'cover' => "Savings1.png",
      'description' => fake()->paragraph(1),
      'target_balance' => fake()->randomNumber(6, true),
      'status' => true,
      'key' => Str::random(10),
      'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id
    ];
  }
}
