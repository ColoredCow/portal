<?php

namespace App\Services;

use Modules\HR\Entities\Employee;
use App\Models\UsersResourcesGuidelines;

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

    public function updateOrCreateUsersResourcesGuideline($data, $employee)
    {
        foreach ($data['category'] as $index => $category) {
            $resource = UsersResourcesGuidelines::updateOrCreate(
                ['category' => isset($data['mark_as_read'][$index]) ? $category : null,
                 'user_id' => isset($data['mark_as_read'][$index]) && $data['mark_as_read'][$index] ? $employee->id : null,
                'mark_as_read' => isset($data['mark_as_read'][$index]) ? $data['mark_as_read'][$index] : null],
                [
                'post_suggestions' => isset($data['post_suggestion'][$index]) && isset($data['mark_as_read'][$index]) ? $data['post_suggestion'][$index] : null
                ]
            );
        }

        return redirect()->back()->with('success', 'Resources saved successfully');
    }
}
