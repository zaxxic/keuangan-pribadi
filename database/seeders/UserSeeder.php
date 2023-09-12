<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = ['admin', 'user'];

        foreach ($users as $user) {
            ([
                'name' => $user
            ]);
            $profile = User::query()
                ->create([
                    'id' => Uuid::uuid(),
                    'name' => $user,
                    'role' => $user,
                    'email' => $user . "@gmail.com",
                    'password' => bcrypt('Password'),
                ]);
        }
    }
}
