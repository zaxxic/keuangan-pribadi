<?php

namespace Database\Seeders;

use App\Models\expenditure_category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenditureCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $categoryNames = ['kebutuhan', 'urgent', 'hiburan'];

            foreach ($categoryNames as $categoryName) {
                expenditure_category::create([
                    'user_id' => $admin->id,
                    'name' => $categoryName,
                    'type' => 'default',
                ]);
            }
        }
    }
}
