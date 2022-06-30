<?php

namespace App\Services;

use Modules\HR\Entities\Employee;

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
}
