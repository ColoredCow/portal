<?php
namespace Modules\Invoice\Console;

use Illuminate\Console\Command;
use Modules\Invoice\Entities\EmployeeLoan;
use Modules\Invoice\Entities\LoanInstallment;

class SeedLoanInstallmentForMonth extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'loan:seed-loan-installment-for-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create entry of this month loan installment';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $loans = EmployeeLoan::with('employee')->where('status', 'active')->get();

        foreach ($loans as $loan) {
            if ($loan->employee->terminated_date && optional($loan->employee->terminated_date)->endOfMonth() < today()->endOfMonth()) {
                continue;
            }

            $remainingBalance = $loan->remaining_balance;

            if ($remainingBalance <= 0) {
                continue;
            }

            $currentMonthDeduction = $loan->current_month_deduction;
            $remainingBalance = $remainingBalance - $currentMonthDeduction;

            if ($remainingBalance < 0) {
                $remainingBalance = 0;
            }

            LoanInstallment::create([
                'loan_id' => $loan->id,
                'installment_amount' => $currentMonthDeduction,
                'remaining_amount' => $remainingBalance,
                'installment_date' => today()->endOfMonth(),
            ]);
        }
    }
}
