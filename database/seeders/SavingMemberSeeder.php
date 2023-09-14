<?php

namespace Database\Seeders;

use App\Models\Saving;
use App\Models\SavingMember;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingMemberSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    for ($i = 0; $i < 6; $i++) {
      $saving = Saving::inRandomOrder()->first();
      $members = SavingMember::where('saving_id', $saving->id)->get()->toArray();
      $membersId = [];
      foreach ($members as $member) {
        $membersId[] = $member['user_id'];
      }
      $user = User::where('role', 'user')->whereNotIn('id', $membersId)->where('id', '!=', $saving->user->id)->inRandomOrder()->first();
      if ($user) {
        SavingMember::create([
          'user_id' => $user->id,
          'saving_id' => $saving->id
        ]);
      }
    }
  }
}
