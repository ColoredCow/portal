<?php

namespace Modules\operations\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class OperationsPolicy
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
        return $user->can('operations.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Operations $operations)
    {
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\User\Entities\User  $user
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Operations $operations)
    {
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Operations  $operations
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Operations $operations)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\User\Entities\User  $user
     */
    public function restore(User $user, Operations $operations)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Operations $operations)
    {
    }
}
