<?php

namespace Modules\Invoice\Services;

use Carbon\Carbon;
use Modules\HR\Entities\Employee;
use Modules\Invoice\Entities\EmployeeLoan;
use Modules\Invoice\Entities\LoanInstallment;

class EmployeeLoanService
{
    public function index(array $params)
    {
        $employeeLoans = EmployeeLoan::with('employee')->where('status', $params['status'] ?? config('invoice.loan.status.active.slug'))->orderBy('employee_id')->get();

        return [
            'employeeLoans' => $employeeLoans,
        ];
    }

    public function create(array $params)
    {
        $allEmployees = Employee::with('user')->get()->sortBy(function ($user) {
            return $user->name;
        });

        return [
            'allEmployees' => $allEmployees,
        ];
    }

    public function edit(EmployeeLoan $employeeLoan)
    {
        $installments = LoanInstallment::where('loan_id', $employeeLoan->id)->orderBy('installment_date')->get();

        return [
            'employeeLoan' => $employeeLoan,
            'installments' => $installments,
        ];
    }

    public function store(array $params)
    {
        EmployeeLoan::create([
            'employee_id' => $params['employee_id'],
            'total_amount' => $params['total_amount'],
            'description' => $params['description'],
            'monthly_deduction' => $params['monthly_deduction'],
            'start_date' => Carbon::parse($params['start_date']),
            'end_date' => Carbon::parse($params['end_date'])->endOfMonth(),
        ]);
    }

    public function update(array $params, EmployeeLoan $employeeLoan)
    {
        $newStartDate = Carbon::parse($params['start_date']);
        $monthlyDeduction = $params['monthly_deduction'];
        if (! $employeeLoan->start_date->isSameMonth($newStartDate)) {
            $this->createOrRemoveLoanInstallmentData($employeeLoan, $newStartDate, $monthlyDeduction);
        }

        $employeeLoan->update([
            'total_amount' => $params['total_amount'],
            'monthly_deduction' => $params['monthly_deduction'],
            'description' => $params['description'],
            'status' => $params['status'],
            'start_date' => $newStartDate,
            'end_date' => Carbon::parse($params['end_date'])->endOfMonth(),
        ]);
    }

    private function createOrRemoveLoanInstallmentData($loan, $startDate, $monthlyDeduction)
    {
        $existingInstallments = $loan->installments;

        foreach ($existingInstallments as $installment) {
            $installment->analyticEntry()->delete();
            $installment->delete();
        }

        $remainingAmount = $loan->total_amount;
        $startDate->endOfMonth();
        while ($startDate <= today() && $remainingAmount > 0) {
            $remainingAmount -= $monthlyDeduction;
            LoanInstallment::create([
                'loan_id' => $loan->id,
                'installment_amount' => $remainingAmount < 0 ? $monthlyDeduction + $remainingAmount : $monthlyDeduction,
                'remaining_amount' => $remainingAmount < 0 ? 0 : $remainingAmount,
                'installment_date' => $startDate->endOfMonth(),
            ]);
            $startDate->addDay()->endOfMonth();
        }
    }
}
