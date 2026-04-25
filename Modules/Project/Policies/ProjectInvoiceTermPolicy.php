<?php

namespace Modules\Project\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Modules\User\Entities\User;

class ProjectInvoiceTermPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function view(User $user, ProjectInvoiceTerm $term)
    {
        if (! $user->hasPermissionTo('projects.view')) {
            return false;
        }

        $project = $term->project;
        if (! $project) {
            return false;
        }

        $isKAM = (int) optional($project->client)->key_account_manager_id === (int) $user->id;
        if ($isKAM) {
            return true;
        }

        return $project->teamMembers()->where('users.id', $user->id)->exists();
    }
}
