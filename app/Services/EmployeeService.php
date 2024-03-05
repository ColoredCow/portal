<?php

namespace App\Services;

use Modules\HR\Entities\Employee;

class EmployeeService
{
    public function index($filters = [])
    {
        $employees = Employee::applyFilters($filters)
            ->leftJoin('project_team_members', 'employees.user_id', '=', 'project_team_members.team_member_id')
            ->leftJoin('projects', 'project_team_members.project_id', '=', 'projects.id')
            ->where('projects.status', 'active')
            ->where('project_team_members.ended_on', null)
            ->selectRaw('employees.*, team_member_id, count(team_member_id) as active_project_count')
            ->groupBy('employees.user_id')
            ->orderby('active_project_count', 'desc')
            ->get();

        return [
            'employees' => $employees,
            'filters' => $filters,
        ];
    }

    public function defaultFilters()
    {
        return [
            'status' => 'current',
            'employee_name' => '',
            'staff_type' => ''
        ];
    }
}
