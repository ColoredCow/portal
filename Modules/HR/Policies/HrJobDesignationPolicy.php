<?php

namespace Modules\HR\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\HR\Entities\HrJobDesignation;
use Modules\User\Entities\User;

class HrJobDesignationPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, HrJobDesignation $HrJobDesignation)
    {
        return $user->hasPermissionTo('hr_job_designation.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('hr_job_designation.create');
    }

    public function update(User $user, HrJobDesignation $HrJobDesignation)
    {
        return $user->hasPermissionTo('hr_job_designation.update');
    }

    public function delete(User $user, HrJobDesignation $HrJobDesignation)
    {
        return $user->hasPermissionTo('hr_job_designation.delete');
    }

    public function list(User $user)
    {
        return $user->hasPermissionTo('hr_job_designation.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('hr_job_designation.view');
    }
}
