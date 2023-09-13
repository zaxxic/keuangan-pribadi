<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $content = 'income';
    $defaultCategories = ['Gaji', 'Bonus', 'Uang Saku'];

    foreach ($defaultCategories as $categories) {
      Category::create([
        'name' => $categories,
        'type' => 'default',
        'content' => $content,
        'user_id' => User::where('role', 'admin')->first()->id
      ]);
    }

    $localCategories = ['Uang nemu', 'Uang kas'];

    foreach ($localCategories as $categories) {
      Category::create([
        'name' => $categories,
        'type' => 'local',
        'content' => $content,
        'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id
      ]);
    }
  }
}
