<?php

namespace App\Policies\HR;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\HR\Entities\Applicant;
use Modules\User\Entities\User;

class ApplicantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the applicant.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\HR\Entities\Applicant  $applicant
     * @return mixed
     */
    public function view(User $user, Applicant $applicant)
    {
        return $user->hasPermissionTo('hr_applicants.view');
    }

    /**
     * Determine whether the user can create applicants.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('hr_applicants.create');
    }

    /**
     * Determine whether the user can update the applicant.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\HR\Entities\Applicant  $applicant
     * @return mixed
     */
    public function update(User $user, Applicant $applicant)
    {
        return $user->hasPermissionTo('hr_applicants.update');
    }

    /**
     * Determine whether the user can delete the applicant.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\HR\Entities\Applicant  $applicant
     * @return mixed
     */
    public function delete(User $user, Applicant $applicant)
    {
        return $user->hasPermissionTo('hr_applicants.delete');
    }

    /**
     * Determine whether the user can list applicants.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('hr_applicants.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('hr_applicants.view');
    }
}
