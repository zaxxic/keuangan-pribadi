<?php

namespace Database\Seeders;

use App\Models\Income_category;
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
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $categoryNames = ['gajian', 'sangu', 'bonus'];

            foreach ($categoryNames as $categoryName) {
                Income_category::create([
                    'user_id' => $admin->id,
                    'name' => $categoryName,
                    'type' => 'default',
                ]);
            }
        }
    }
}
