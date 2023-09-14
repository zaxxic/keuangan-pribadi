<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('date_before_today', function ($attribute, $value, $parameters, $validator) {
            $date = \Carbon\Carbon::parse($value);
            return $date->isBefore(\Carbon\Carbon::now());
        });
        
        User::observe(UserObserver::class);
    }
}
