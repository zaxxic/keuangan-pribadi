<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\HistoryTransaction;
use App\Models\RegularTransaction;
use App\Models\Saving;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::create([
      'name' => fake()->name(),
      'email' => 'admin@gmail.com',
      'gender' => 'undefined',
      'birthday' => fake()->date(),
      'password' => bcrypt('password'),
      'role' => 'admin',
    ]);

    User::factory(3)->create();

    $this->call(IncomeCategorySeeder::class);

    $this->call(ExpenditureCategorySeeder::class);

    HistoryTransaction::factory(999)->create();

    RegularTransaction::factory(5)->create();

    $this->call(SubscriberSeeder::class);

    Saving::factory(4)->create();

    $this->call(SavingMemberSeeder::class);

    $this->call(RegularSavingSeeder::class);

    $this->call(HistorySavingSeeder::class);
  }
}
