<?php

namespace App\Policies\KnowledgeCafe;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class WeeklyDosePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the weekly dose.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\KnowledgeCafe\WeeklyDose  $weeklyDose
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('weeklydoses.view');
    }

    /**
     * Determine whether the user can list weeklydoses.
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('weeklydoses.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('weeklydoses.view');
    }
}
