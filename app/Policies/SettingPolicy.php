<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissionTo('settings.view');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('settings.update');
    }
}
