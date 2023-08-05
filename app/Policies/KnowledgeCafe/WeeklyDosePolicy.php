<?php

namespace App\Policies\KnowledgeCafe;

use App\Models\KnowledgeCafe\WeeklyDose;
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
    public function view(User $user, WeeklyDose $weeklyDose)
    {
        return $user->hasPermissionTo('weeklydoses.view');
    }

    /**
     * Determine whether the user can create weekly doses.
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the weekly dose.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\KnowledgeCafe\WeeklyDose  $weeklyDose
     *
     * @return bool
     */
    public function update(User $user, WeeklyDose $weeklyDose)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the weekly dose.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\KnowledgeCafe\WeeklyDose  $weeklyDose
     *
     * @return bool
     */
    public function delete(User $user, WeeklyDose $weeklyDose)
    {
        return false;
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
