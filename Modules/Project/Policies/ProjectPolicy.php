<?php

namespace Modules\Project\Policies;

use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('projects.view');
    }

    public function view(User $user, Project $project)
    {
        return $user->hasPermissionTo('projects.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('projects.create');
    }

    public function update(User $user, Project $project)
    {
        return $user->hasPermissionTo('projects.update') || $project->client->key_account_manager_id === $user->id;
    }

    public function delete(User $user, Project $project)
    {
        return $user->hasPermissionTo('projects.delete');
    }
}
