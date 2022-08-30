<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class Cronpolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('cron.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('cron.index');
    }

    public function isSuperAdmin(user $user)
    {
        return $user->hasPermissionTo('cron.index');
    }
}
