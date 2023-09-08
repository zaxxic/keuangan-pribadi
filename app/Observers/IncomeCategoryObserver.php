<?php

namespace App\Observers;

use App\Models\income_category;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;



class IncomeCategoryObserver
{
    /**
     * Handle the income_category "created" event.
     */
    public function created(income_category $income_category): void
    {
        $income_category->id = Str::uuid();
    }
}
