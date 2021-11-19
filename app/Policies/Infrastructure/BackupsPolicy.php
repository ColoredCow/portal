<?php

namespace App\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BackupsPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view the backups.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('infrastructure.backups.view');
    }
}
