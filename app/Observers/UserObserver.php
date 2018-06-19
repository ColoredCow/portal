<?php

namespace App\Observers;

use App\Models\HR\Employee;
use App\User;

class UserObserver
{
    /**
     * Handle to the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        if ($user->isActiveEmployee) {
            Employee::create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);
        }
    }
}
