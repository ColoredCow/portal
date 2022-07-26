<?php

namespace Modules\Salary\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;
use App\Traits\Encryptable;

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
