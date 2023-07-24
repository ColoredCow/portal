<?php

namespace Modules\CodeTrek\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\User\Entities\User;

class CodeTrekApplicantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('codetrek_applicant.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function view(User $user, CodeTrekApplicant $applicant)
    {
        return $user->hasPermissionTo('codetrek_applicant.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user, CodeTrekApplicant $applicant)
    {
        return $user->hasPermissionTo('codetrek_applicant.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function update(User $user, CodeTrekApplicant $applicant)
    {
        return $user->hasPermissionTo('codetrek_applicant.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function delete(User $user, CodeTrekApplicant $applicant)
    {
        return $user->hasPermissionTo('codetrek_applicant.delete');
    }
}
