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
        $employees = Employee::whereHas('user', function ($query) {
            $query->whereNull('deleted_at');
        })->applyFilters($filters)->select('employees.*')
            ->selectSub(function ($query) {
                $query->select('commencement_date')
                    ->from('employee_salaries')
                    ->whereColumn('employee_id', 'employees.id')
                    ->orderBy('commencement_date', 'desc')
                    ->limit(1);
            }, 'latest_commencement_date')
            ->orderBy('latest_commencement_date')
            ->orderBy('name')
            ->get();

        return [
            'employees' => $employees,
            'filters' => $filters,
        ];
    }

    public function getEmployeeListForExport()
    {
        $employees = Employee::with('user')->whereHas('user', function ($query) {
            $query->whereNull('deleted_at');
        })
            ->orderBy('name')
            ->get();

        return [
            'employees' => $employees,
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
    public function fetchEmployeeEarnings($employeeId)
    {
    $employees = Employee::leftJoin('project_team_members', 'employees.user_id', '=', 'project_team_members.team_member_id')
    ->leftJoin('projects', 'project_team_members.project_id', '=', 'projects.id')
    ->leftJoin('project_billing_details', 'projects.id', '=', 'project_billing_details.project_id')
    ->leftJoin('project_team_members_effort', 'project_team_members.id', '=', 'project_team_members_effort.project_team_member_id')
    ->select(
        'employees.id',
        'employees.user_id',
        'employees.name',
        'employees.staff_type',
        'project_team_members.project_id as ptm_project_id',
        'project_team_members.team_member_id as ptm_team_member_id', 
        'projects.type as project_type',
        'projects.name as project_name',
        'projects.status as project_status',
        'projects.is_amc',
        'project_billing_details.project_id as pb_project_id',
        'project_billing_details.service_rates',
        'project_billing_details.service_rate_term',
        'project_billing_details.currency',
        'project_team_members_effort.id',
        'project_team_members_effort.actual_effort',
        'project_team_members_effort.total_effort_in_effortsheet'
    )
    ->where('employees.id', $employeeId)
    ->where('projects.status', 'active')
    ->get();

    
        return [
            'employees' => $employees,
            'filters' => [], 
        ];
    }
    

}
