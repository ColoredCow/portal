<?php

namespace App\Policies\HR;

use App\Models\HR\University;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class UniversityPolicy
{
    use HandlesAuthorization;

    public function view(User $user, University $university)
    {
        return $user->hasPermissionTo('hr_universities.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('hr_universities.create');
    }

    public function update(User $user, University $university)
    {
        return $user->hasPermissionTo('hr_universities.update');
    }

    public function delete(User $user, University $university)
    {
        return $user->hasPermissionTo('hr_universities.delete');
    }

    public function list(User $user)
    {
        return $user->hasPermissionTo('hr_universities.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('hr_universities.view');
    }
}
