<?php

namespace App\Observers;

use Carbon\Carbon;
use Modules\HR\Entities\Employee;
use Modules\User\Entities\User;

class UserObserver
{
    /**
     * Handle to the user "created" event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        Employee::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'joined_on' => Carbon::today(),
        ]);
    }
}
