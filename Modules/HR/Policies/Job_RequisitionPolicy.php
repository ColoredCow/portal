<?php

namespace Modules\HR\Policies;

use Modules\HR\Entities\JobRequisition;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class JobRequisitionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, JobRequisition $JobRequisition)
    {
        return $user->hasPermissionTo('job_Requisition.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('job_Requisition.create');
    }

    public function update(User $user, JobRequisition $JobRequisition)
    {
        return $user->hasPermissionTo('job_Requisition.update');
    }

    public function delete(User $user, JobRequisition $JobRequisition)
    {
        return $user->hasPermissionTo('job_Requisition.delete');
    }

    public function list(User $user)
    {
        return $user->hasPermissionTo('job_Requisition.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('job_Requisition.view');
    }
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}