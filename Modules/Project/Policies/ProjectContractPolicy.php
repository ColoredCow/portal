<?php

namespace Modules\Project\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Project\Entities\ProjectContract;
use Modules\User\Entities\User;

class ProjectContractPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ProjectContract $contract)
    {
        if (! $user->hasPermissionTo('projects.view')) {
            return false;
        }

        $project = $contract->project;
        if (! $project) {
            return false;
        }

        $isKAM = optional($project->client)->key_account_manager_id === $user->id;
        if ($isKAM) {
            return true;
        }

        return $project->teamMembers()->where('users.id', $user->id)->exists();
    }
}
