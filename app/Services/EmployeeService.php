<?php

namespace App\Services;

use Modules\HR\Entities\Employee;
use App\Models\UsersResourcesAndGuidelines;

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

    public function updateOrCreateUsersResourcesAndGuidelines($data, $employee)
    {
        foreach ($data['resource_id'] as $index => $resource_id) {
            if (! empty($employee->id) && ! empty($resource_id)) {
                $mark_as_read = isset($data['mark_as_read'][$resource_id]) ? 1 : 0;
                $resource = UsersResourcesAndGuidelines::updateOrCreate(
                    [
                     'resource_id' => $resource_id,
                     'employee_id' => $employee->id
                    ],
                    [
                     'mark_as_read' => $mark_as_read,
                     'post_suggestions' => isset($data['post_suggestion'][$resource_id]) ? $data['post_suggestion'][$resource_id] : null
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Resources saved successfully');
    }
}
