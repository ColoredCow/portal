<?php

namespace App\Policies;

use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Project  $project
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('projects.view');
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('projects.create');
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Project  $project
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('projects.update');
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \App\Models\Project  $project
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('projects.delete');
    }

    /**
     * Determine whether the user can list projects.
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('projects.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('projects.view');
    }
}
