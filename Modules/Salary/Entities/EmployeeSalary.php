<?php

namespace Modules\Salary\Entities;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;

class EmployeeSalary extends Model
{
    use Encryptable;

    protected $fillable = ['employee_id', 'monthly_gross_salary'];

    protected $encryptable = ['monthly_gross_salary'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
