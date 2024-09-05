<?php

namespace Modules\Salary\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class EmployeeSalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the salary.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('employee_salary.view');
    }

    /**
     * Determine whether the user can create salaries.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('employee_salary.create');
    }

    /**
     * Determine whether the user can update the salary.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('employee_salary.update');
    }

    /**
     * Determine whether the user can delete the salary.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('employee_salary.delete');
    }

    /**
     * Determine whether the user can list salary.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('employee_salary.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('employee_salary.view');
    }
}
