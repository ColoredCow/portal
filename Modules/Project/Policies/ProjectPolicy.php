<?php

namespace Modules\Project\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
 

class ProjectPolicy
{
    use HandlesAuthorization;
    
    public function view(User $user)
    {
        return $user->hasPermissionTo('projects.view');
    }
}