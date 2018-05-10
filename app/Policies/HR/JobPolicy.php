<?php

namespace App\Policies\HR;

use App\User;
use App\Models\HR\Job;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the job.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HR\Job  $job
     * @return mixed
     */
    public function view(User $user, Job $job)
    {
        return $user->hasPermissionTo('view.hr_jobs');
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create.hr_jobs');
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HR\Job  $job
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        return $user->hasPermissionTo('update.hr_jobs');
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HR\Job  $job
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        return $user->hasPermissionTo('delete.hr_jobs');
    }
}
