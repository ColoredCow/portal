<?php

namespace App\Services;

use App\Contracts\EmployeeServiceContract;
use Modules\HR\Entities\Employee;
use Illuminate\Support\Arr;

class EmployeeService implements EmployeeServiceContract
{
    public function index($filters = [])
    {
        $filters = [
            'status' => $filters['status'] ?? null,
        ];
        $query = Employee::query();
        $employees = Employee::active()->orderBy('name')->get();
        $employees = $this
            ->applyFilters($query, $filters)
            ->get();

        return [
            'employees' => $employees,
            'filters' => $filters,
        ];
    }

    public function defaultFilters()
    {
        return [
            'status' => 'active',
        ];
    }

    private function applyFilters($query, $filters)
    {
        if ($status = Arr::get($filters, 'status', '')) {
            $query = $query->status($status);
        }

        return $query;
    }
}
