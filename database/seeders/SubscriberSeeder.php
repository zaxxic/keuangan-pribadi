<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = User::where('role', 'user')->get();

    foreach ($users as $user) {
      for ($i = 0; $i < 2; $i++) {
        Subscriber::create([
          'expire_date' => fake()->dateTimeInInterval('-3 months', '+2 months'),
          'amount' => fake()->randomNumber(5, true),
          'status' => 'off',
          'user_id' => $user->id
        ]);
      }
    }

    Subscriber::create([
      'expire_date' => fake()->dateTimeInInterval('+ 1 month', '+1 day'),
      'amount' => fake()->randomNumber(5, true),
      'status' => 'active',
      'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id
    ]);
  }
}
