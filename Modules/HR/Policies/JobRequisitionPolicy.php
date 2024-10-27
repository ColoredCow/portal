<?php

namespace Modules\HR\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class JobRequisitionPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissionTo('hr_job_requisition.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('hr_job_requisition.create');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('hr_job_requisition.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('hr_job_requisition.delete');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('hr_job_requisition.view');
    }
}
