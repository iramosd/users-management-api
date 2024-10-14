<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\CredentialsNotification;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->notify(new CredentialsNotification($user));
    }
}
