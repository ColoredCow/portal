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
            'installments' => $installments
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
        $employeeLoan->update([
            'total_amount' => $params['total_amount'],
            'monthly_deduction' => $params['monthly_deduction'],
            'description' => $params['description'],
            'status' => $params['status'],
            'start_date' => Carbon::parse($params['start_date']),
            'end_date' => Carbon::parse($params['end_date'])->endOfMonth(),
        ]);
    }
}
