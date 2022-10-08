<?php

namespace App\Services;

use Modules\HR\Entities\Employee;
use Spatie\Permission\Models\Role;

class EmployeeService
{
    public function index($filters = [])
    {
        $employees = Employee::active()
            ->orderBy('name')
            ->applyFilters($filters)
            ->get();
        $nameA = 'employee';
        $nameB = 'intern';
        $nameC = 'contractor';
        $nameD = 'support-staff';
        $foo = request('n');
        $roles = Role::all()->get('name');
        
        return [
            'foo' => $foo,
            'nameA' => $nameA,
            'nameB' => $nameB,
            'nameC' => $nameC,
            'nameD' => $nameD,
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
