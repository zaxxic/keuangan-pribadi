<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\HistorySaving;
use App\Models\HistoryTransaction;
use App\Models\RegularTransaction;
use App\Models\Saving;
use App\Models\SavingMember;
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

    HistoryTransaction::factory(100)->create();

    RegularTransaction::factory(5)->create();

    $this->call(SubscriberSeeder::class);

    Saving::factory(4)->create();

    SavingMember::factory(6)->create();

    $this->call(RegularSavingSeeder::class);

    HistorySaving::factory(20)->create();
  }
}
