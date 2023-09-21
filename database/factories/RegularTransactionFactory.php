<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegularTransaction>
 */
class RegularTransactionFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $method = [null, 'Cash', 'Kredit', 'E-Wallet'];
    $content = ['income', 'expenditure'];
    $recurring = ['once', 'week', 'month', 'year'];
    return [
      'title' => fake()->sentence(1),
      'amount' => fake()->randomNumber(5, true),
      'payment_method' => $method[array_rand($method, 1)],
      'recurring' => $recurring[array_rand($recurring, 1)],
      'count' => $count = fake()->randomDigitNotNull(), 
      'real' => $count,
      'content' => $content[array_rand($content, 1)],
      'date' => fake()->dateTimeInInterval('+ 1 week', '+4 weeks'),
      'description' => fake()->paragraph(1),
      'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id,
      'category_id' => Category::inrandomOrder()->first()->id
    ];
  }
}
