<?php

namespace App\Policies;

use App\User;
use App\Models\WeeklyDose;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeeklyDosePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the weekly dose.
     *
     * @param  \App\User  $user
     * @param  \App\Models\WeeklyDose  $weeklyDose
     * @return mixed
     */
    public function view(User $user, WeeklyDose $weeklyDose)
    {
        return $user->hasPermissionTo('view.weeklydoses');
    }

    /**
     * Determine whether the user can create weekly doses.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the weekly dose.
     *
     * @param  \App\User  $user
     * @param  \App\Models\WeeklyDose  $weeklyDose
     * @return boolean
     */
    public function update(User $user, WeeklyDose $weeklyDose)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the weekly dose.
     *
     * @param  \App\User  $user
     * @param  \App\Models\WeeklyDose  $weeklyDose
     * @return boolean
     */
    public function delete(User $user, WeeklyDose $weeklyDose)
    {
        return false;
    }
}
