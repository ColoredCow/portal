<?php

namespace Modules\HR\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\HR\Entities\Employee;
use Modules\User\Entities\User;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('hr_employees.view');
    }

    public function view(User $user, Employee $employee)
    {
        return $user->id === $employee->user_id || $user->hasPermissionTo('hr_employees.view');
    }

    public function list(User $user)
    {
        return $user->hasPermissionTo('hr_employees.view');
    }

    public function listPayroll(User $user)
    {
        return $user->hasPermissionTo('employee_salary.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('hr_employees.create');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('hr_employees.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('hr_employees.delete');
    }

    public function reports(User $user)
    {
        return $user->hasPermissionTo('hr_employees_reports.view');
    }
}
