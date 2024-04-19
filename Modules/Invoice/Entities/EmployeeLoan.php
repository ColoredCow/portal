<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;

class EmployeeLoan extends Model
{
    use Encryptable;

    protected $table = 'employees_loan';
    protected $guarded = [];
    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];
    protected $encryptable = ['total_amount', 'monthly_deduction'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
