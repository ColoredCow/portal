<?php

namespace Modules\Invoice\Observers;

use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\EmployeeLoan;
use Modules\Invoice\Entities\EmployeeLoanAnalyticsEncryptedData;

class EmployeeLoanObserver
{
    /**
     * Handle the EmployeeLoan "created" event.
     *
     * @param  \Modules\Invoice\Entities\EmployeeLoan  $loan
     * @return void
     */
    public function created(EmployeeLoan $loan)
    {
        $aes_encrypted_total_amount = $this->encryptValue($loan->total_amount);
        $aes_encrypted_monthly_deduction = $this->encryptValue($loan->monthly_deduction);
        EmployeeLoanAnalyticsEncryptedData::create([
            'loan_id' => $loan->id,
            'total_amount' => $aes_encrypted_total_amount,
            'monthly_deduction' => $aes_encrypted_monthly_deduction,
        ]);
    }

    /**
     * Handle the EmployeeLoan "updated" event.
     *
     * @param  \Modules\Invoice\Entities\EmployeeLoan  $loan
     * @return void
     */
    public function updated(EmployeeLoan $loan)
    {
        $aes_encrypted_total_amount = $this->encryptValue($loan->total_amount);
        $aes_encrypted_monthly_deduction = $this->encryptValue($loan->monthly_deduction);
        $employeeLoanAnalyticsEntity = EmployeeLoanAnalyticsEncryptedData::where('loan_id', $loan->id);

        if (! $employeeLoanAnalyticsEntity) {
            return;
        }

        $employeeLoanAnalyticsEntity->update([
            'total_amount' => $aes_encrypted_total_amount,
            'monthly_deduction' => $aes_encrypted_monthly_deduction,
        ]);
    }

    /**
     * Handle the EmployeeLoan "deleted" event.
     *
     * @param  \Modules\Invoice\Entities\EmployeeLoan  $loan
     * @return void
     */
    public function deleted(EmployeeLoan $loan)
    {
        $employeeLoanAnalyticsEntity = EmployeeLoanAnalyticsEncryptedData::where('loan_id', $loan->id);

        if (! $employeeLoanAnalyticsEntity) {
            return;
        }

        $employeeLoanAnalyticsEntity->delete();
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
     * @param  \Modules\Invoice\Entities\Invoice  $loan
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
