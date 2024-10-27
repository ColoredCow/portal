<?php
namespace Modules\HR\Policies\Recruitment;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\HR\Entities\Job;
use Modules\User\Entities\User;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the job.
     *
     * @param  User  $user
     * @param  Job  $job
     *
     * @return mixed
     */
    public function view(User $user, Job $job)
    {
        if ($job->type == 'volunteer') {
            return $user->hasPermissionTo('hr_volunteers_jobs.view');
        }

        return $user->hasPermissionTo('hr_recruitment_jobs.view');
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        if (request()->is('hr/volunteers*')) {
            return $user->hasPermissionTo('hr_volunteers_jobs.create');
        }

        return $user->hasPermissionTo('hr_recruitment_jobs.create');
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param  User  $user
     * @param  Job  $job
     *
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        if ($job->type == 'volunteer') {
            return $user->hasPermissionTo('hr_volunteers_jobs.update');
        }

        return $user->hasPermissionTo('hr_recruitment_jobs.update');
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  User  $user
     * @param  Job  $job
     *
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        if ($job->type == 'volunteer') {
            return $user->hasPermissionTo('hr_volunteers_jobs.delete');
        }

        return $user->hasPermissionTo('hr_recruitment_jobs.delete');
    }

    /**
     * Determine whether the user can list jobs.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function list(User $user)
    {
        if (request()->is('hr/volunteers*')) {
            return $user->hasPermissionTo('hr_volunteers_jobs.view');
        }

        return $user->hasPermissionTo('hr_recruitment_jobs.view');
    }

    public function viewAny(User $user)
    {
        if (request()->is('hr/volunteers*')) {
            return $user->hasPermissionTo('hr_volunteers_jobs.view');
        }

        return $user->hasPermissionTo('hr_recruitment_jobs.view');
    }
}
