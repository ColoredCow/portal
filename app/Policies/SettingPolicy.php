<?php

namespace App\Policies;

use App\User;
use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the setting.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function view(User $user, Setting $setting)
    {
        return $user->hasPermissionTo('view.settings');
    }

    /**
     * Determine whether the user can create settings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create.settings');
    }

    /**
     * Determine whether the user can update the setting.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function update(User $user, Setting $setting)
    {
        return $user->hasPermissionTo('update.settings');
    }

    /**
     * Determine whether the user can delete the setting.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function delete(User $user, Setting $setting)
    {
        return $user->hasPermissionTo('delete.settings');
    }
}
