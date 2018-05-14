<?php

namespace App\Policies\HR;

use App\User;
use App\Models\HR\Applicant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the applicant.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HR\Applicant  $applicant
     * @return mixed
     */
    public function view(User $user, Applicant $applicant)
    {
        return $user->hasPermissionTo('hr_applicants.view');
    }

    /**
     * Determine whether the user can create applicants.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('hr_applicants.create');
    }

    /**
     * Determine whether the user can update the applicant.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HR\Applicant  $applicant
     * @return mixed
     */
    public function update(User $user, Applicant $applicant)
    {
        return $user->hasPermissionTo('hr_applicants.update');
    }

    /**
     * Determine whether the user can delete the applicant.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HR\Applicant  $applicant
     * @return mixed
     */
    public function delete(User $user, Applicant $applicant)
    {
        return $user->hasPermissionTo('hr_applicants.delete');
    }
}
