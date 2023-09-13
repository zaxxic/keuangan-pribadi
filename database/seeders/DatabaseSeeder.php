<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
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
  }
}
