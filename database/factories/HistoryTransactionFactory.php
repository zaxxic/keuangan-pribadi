<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistoryTransaction>
 */
class HistoryTransactionFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $method = ['Cash', 'Kredit', 'E-Wallet'];
    $content = ['income', 'expenditure'];
    return [
      'title' => fake()->sentence(1),
      'amount' => fake()->randomNumber(5, true),
      'payment_method' => $method[array_rand($method, 1)],
      'attachment' => 'evidence.jpg',
      'content' => $content[array_rand($content, 1)],
      'date' => fake()->dateTimeInInterval('-6 months', '+6 months'),
      'description' => fake()->paragraph(1),
      'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id,
      'category_id' => Category::inrandomOrder()->first()->id
    ];
  }
}
