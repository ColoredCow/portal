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
            ->selectRaw('employees.*, team_member_id, count(case when projects.status = "active" and project_team_members.ended_on is null then 1 else null end) as active_project_count')
            ->groupBy('employees.user_id')
            ->orderby('active_project_count', 'desc')
            ->get();

        return [
            'employees' => $employees,
            'filters' => $filters,
        ];
    }

    public function getEmployeeListWithLatestPayroll($filters = [])
    {
        $employees = Employee::applyFilters($filters)->select('employees.*')
            ->selectSub(function ($query) {
                $query->select('commencement_date')
                    ->from('employee_salaries')
                    ->whereColumn('employee_id', 'employees.id')
                    ->orderByDesc('commencement_date')
                    ->limit(1);
            }, 'latest_commencement_date')
            ->orderBy('latest_commencement_date', 'asc')
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
            'staff_type' => '',
        ];
    }
}
