<?php

namespace App\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return true;
        return $user->hasPermissionTo('settings.view');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('settings.update');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('settings.view');
    }
}
