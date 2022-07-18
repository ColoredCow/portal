<?php

namespace Modules\Salary\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;

class EmployeeSalary extends Model
{
    protected $fillable = ['employee_id', 'gross_salary'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
