<?php

namespace App\Policies\HR;

use App\Models\HR\Job;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class UniversityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\University  $university
     * @return mixed
     */
    public function view(User $user, University $university)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\University  $university
     * @return mixed
     */
    public function update(User $user, University $university)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\University  $university
     * @return mixed
     */
    public function delete(User $user, University $university)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\University  $university
     * @return mixed
     */
    public function restore(User $user, University $university)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\University  $university
     * @return mixed
     */
    public function forceDelete(User $user, University $university)
    {
        //
        return true;
    }
}
