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

    public function installments()
    {
        return $this->hasMany(LoanInstallment::class, 'loan_id');
    }

    public function getTenureInMonthsAttribute()
    {
        $endDate = $this->end_date;
        $startDate = $this->start_date;
        $diffInMonths = ($endDate->year - $startDate->year) * 12 + ($endDate->month - $startDate->month);

        return $diffInMonths + 1;
    }

    public function getCurrentMonthDeductionAttribute()
    {
        $thisMonthDeduction = (float) $this->monthly_deduction;
        $balance = $this->remaining_balance;

        if ($balance <= 0) {
            return 0;
        }

        return min($thisMonthDeduction, (float) $balance);
    }

    public function getRemainingBalanceAttribute()
    {
        $lastInstallment = $this->installments()->orderBy('installment_date', 'desc')->first();

        if (! $lastInstallment) {
            return $this->total_amount;
        }

        return $lastInstallment->remaining_amount;
    }
}
