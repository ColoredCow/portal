<?php

namespace App\Policies\Finance;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the salary.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('salary.view');
    }

    /**
     * Determine whether the user can create salaries.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('salary.create');
    }

    /**
     * Determine whether the user can update the salary.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('salary.update');
    }

    /**
     * Determine whether the user can delete the salary.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('salary.delete');
    }

    /**
     * Determine whether the user can list salary.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('salary.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('salary.view');
    }
}
