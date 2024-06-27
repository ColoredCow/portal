<?php

namespace Modules\Invoice\Observers;

use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\EmployeeLoan;
use Modules\Invoice\Entities\LoanInstallment;
use Modules\Invoice\Entities\LoanInstallmentAnalyticsData;

class LoanInstallmentObserver
{
    /**
     * Handle the EmployeeLoan "created" event.
     *
     * @param  \Modules\Invoice\Entities\LoanInstallment  $installment
     * @return void
     */
    public function created(LoanInstallment $installment)
    {
        $aesEncryptedRemainingAmount = $this->encryptValue($installment->total_amount);
        $aesEncryptedInstallmentAmount = $this->encryptValue($installment->installment_amount);
        LoanInstallmentAnalyticsData::create([
            'loan_installment_id' => $installment->id,
            'installment_amount' => $aesEncryptedInstallmentAmount,
            'remaining_amount' => $aesEncryptedRemainingAmount,
        ]);
    }

    /**
     * Handle the EmployeeLoan "updated" event.
     *
     * @param  \Modules\Invoice\Entities\LoanInstallment  $installment
     * @return void
     */
    public function updated(LoanInstallment $installment)
    {
        $aesEncryptedRemainingAmount = $this->encryptValue($installment->total_amount);
        $aesEncryptedInstallmentAmount = $this->encryptValue($installment->installment_amount);
        $loanInstallmentAnalyticsEntity = LoanInstallmentAnalyticsData::where('loan_installment_id', $installment->id)->first();

        if (! $loanInstallmentAnalyticsEntity) {
            return;
        }

        $loanInstallmentAnalyticsEntity->update([
            'installment_amount' => $aesEncryptedInstallmentAmount,
            'remaining_amount' => $aesEncryptedRemainingAmount,
        ]);
    }

    /**
     * Handle the EmployeeLoan "deleted" event.
     *
     * @param  \Modules\Invoice\Entities\LoanInstallment  $installment
     * @return void
     */
    public function deleted(LoanInstallment $installment)
    {
        $loanInstallmentAnalyticsEntity = LoanInstallmentAnalyticsData::where('loan_installment_id', $installment->id)->first();

        if (! $loanInstallmentAnalyticsEntity) {
            return;
        }

        $loanInstallmentAnalyticsEntity->delete();
    }

    /**
     * Handle the EmployeeLoan "restored" event.
     *
     * @param  \Modules\Invoice\Entities\EmployeeLoan  $loan
     * @return void
     */
    public function restored(EmployeeLoan $loan)
    {
        //
    }

    /**
     * Handle the EmployeeLoan "force deleted" event.
     *
     * @param  \Modules\Invoice\Entities\EmployeeLoan  $loan
     * @return void
     */
    public function forceDeleted(EmployeeLoan $loan)
    {
        //
    }

    protected function encryptValue($value)
    {
        $result = DB::select("SELECT TO_BASE64(AES_ENCRYPT('" . $value . "', '" . config('database.connections.mysql.encryption_key') . "')) AS encrypted_value");

        return $result[0]->encrypted_value;
    }
}
