<?php

namespace App\Observers;

use App\Models\User;
use Ramsey\Uuid\Uuid;


class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->id = Uuid::uuid4()->toString();
    }
}
