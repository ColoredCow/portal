<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class LoanInstallment extends Model
{
    use Encryptable;

    protected $table = 'loan_installments';
    protected $guarded = [];
    protected $casts = ['installment_date' => 'datetime'];
    protected $encryptable = ['installment_amount', 'remaining_amount'];

    public function loan()
    {
        return $this->belongsTo(EmployeeLoan::class);
    }

    public function analyticEntry()
    {
        return $this->hasOne(LoanInstallmentAnalyticsData::class, 'loan_installment_id');
    }
}
