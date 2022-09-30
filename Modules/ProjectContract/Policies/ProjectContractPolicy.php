<?php

namespace Modules\ProjectContract\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectContractPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('projectscontract.view');
    }

    public function viewForm(User $user)
    {
        return $user->hasPermissionTo('projectscontract.view');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('projectcontract.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('projectcontract.delete');
    }
}
