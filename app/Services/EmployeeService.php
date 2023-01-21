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
        foreach ($data['category'] as $index => $category) {
            if(!empty($data['mark_as_read'][$index]) && !empty($employee->id) && !empty($category)){
                $resource = UsersResourcesAndGuidelines::updateOrCreate(
                    ['category' => $category,
                     'user_id' => $employee->id,
                     'mark_as_read' => $data['mark_as_read'][$index]],
                    [
                    'post_suggestions' => isset($data['post_suggestion'][$index]) ? $data['post_suggestion'][$index] : null
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Resources saved successfully');
    }
}
