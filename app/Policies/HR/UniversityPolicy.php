<?php

namespace App\Policies\HR;

use App\Models\HR\Job;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class UniversityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
        return true;
    }

    public function view(User $user, University $university)
    {
        //
        return true;
    }

    public function create(User $user)
    {
        //
        return true;
    }

    public function update(User $user, University $university)
    {
        //
        return true;
    }

    public function delete(User $user, University $university)
    {
        //
        return true;
    }

    public function restore(User $user, University $university)
    {
        //
        return true;
    }

    public function forceDelete(User $user, University $university)
    {
        //
        return true;
    }
}
