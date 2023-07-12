<?php

namespace App\Services;

use Modules\HR\Entities\Employee;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\EmployeeAssessmetReviewMail;

class EmployeeService
{
    public function index($filters = [])
    {
        $employees = Employee::active()
            ->orderBy('name')
            ->applyFilters($filters)
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
        ];
    }

    public function sendEmployeeReviewMail($employee, $user, $data)
    {
        $employeeData = [
            'self' => [
                'review_link' => $data['self_review_link'],
                'user' => $user,
            ],
            'hr' => [
                'review_link' => $data['hr_review_link'],
                'employee' => ! empty($employee->hr) ? $employee->hr : null,
                'user' => ! empty($employee->hr) ? $employee->hr->user : null,
            ],
            'mentor' => [
                'review_link' => $data['mentor_review_link'],
                'employee' => ! empty($employee->mentor) ? $employee->mentor : null,
                'user' => ! empty($employee->mentor) ? $employee->mentor->user : null,
            ],
            'manager' => [
                'review_link' => $data['manager_review_link'],
                'employee' => ! empty($employee->manager) ? $employee->manager : null,
                'user' => ! empty($employee->manager) ? $employee->manager->user : null,
            ],
        ];

        foreach ($employeeData as $key => $data) {
            if (! empty($data['user'])) {
                Mail::queue(new EmployeeAssessmetReviewMail($key, $data));
            }
        }
    }
}
