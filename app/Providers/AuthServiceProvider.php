<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Saving;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The model to policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    //
  ];

  /**
   * Register any authentication / authorization services.
   */
  public function boot(): void
  {
    Gate::define('owner', function ($user, Saving $saving) {
      return $user->id === $saving->user_id;
    });

    Gate::define('notSame', function ($user, $member) {
      return $user->id  !== $member;
    });

    Gate::define('members', function($user, Saving $saving) {
      $members = [];
      foreach($saving->members as $member){
        $members[] = $member['id'];
      }
      $members[] = $saving->user_id;

      return in_array($user->id, $members);
    });
  }
}
