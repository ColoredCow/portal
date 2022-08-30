<?php

namespace App\Policies;

use App\Models\setting\Cron;
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
     * @param  \App\Models\Cron  $cron
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Cron $cron)
    {
        return $user->hasPermissionTo('cron.index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('cron.index');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Cron  $cron
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Cron $cron)
    {
        return $user->hasPermissionTo('cron.index');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Cron  $cron
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Cron $cron)
    {
        return $user->hasPermissionTo('cron.index');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Cron  $cron
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Cron $cron)
    {
        return $user->hasPermissionTo('cron.index');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Cron  $cron
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Cron $cron)
    {  
        return $user->hasPermissionTo('cron.index'); 
    }
    public function isSuperAdmin(user $user)
    {
        return $user->hasPermissionTo('cron.index');
    }
}
