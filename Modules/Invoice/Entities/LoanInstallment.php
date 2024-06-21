<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;

class LoanInstallment extends Model
{
    use Encryptable;

    protected $table = 'loan_installments';
    protected $guarded = [];
    protected $dates = ['installment_date', 'created_at', 'updated_at'];
    protected $encryptable = ['installment_amount', 'remaining_amount'];

    public function loan()
    {
        return $this->belongsTo(EmployeeLoan::class);
    }
}
