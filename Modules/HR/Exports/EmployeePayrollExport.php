<?php

namespace Modules\HR\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeePayrollExport implements FromArray, WithHeadings, ShouldAutoSize, WithTitle, WithStyles
{
    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function array(): array
    {
        $data = [];
        $totalGrossSalary = 0;
        $totalBasicSalary = 0;
        $totalHra = 0;
        $totalTransportAllowance = 0;
        $totalOtherAllowance = 0;
        $totalFoodAllowance = 0;
        $totalSalary = 0;
        $daysInMonth = Carbon::now()->daysInMonth;
        $totalDays = 0;
        $totalPaidDays = 0;
        $totalEmployeeEsi = 0;
        $totalEmployeeEpf = 0;
        $totalTds = 0;
        $totalAdvanceRecovery = 0;
        $totalDeduction = 0;
        $totalNetPay = 0;
        $totalEmployerEsi = 0;
        $totalEmployerEpf = 0;
        $totalAdministrationCharges = 0;
        $totalEdliCharges = 0;
        $totalCtc = 0;
        $totalCtcAnnual = 0;
        $totalHealthInsurance = 0;
        $totalCtcAgg = 0;

        foreach ($this->employees as $employee) {
            $currentSalaryObject = $employee->getCurrentSalary();

            if (! $currentSalaryObject) {
                continue;
            }

            $isEmployeeLeavingThisMonth = optional($employee->termination_date)->startOfDay() === today()->startOfDay();

            $totalDays += $daysInMonth;
            $paidDays = $isEmployeeLeavingThisMonth ? $employee->termination_date->day : $daysInMonth;
            $totalPaidDays += $paidDays;

            if ($isEmployeeLeavingThisMonth) {
                $employeeGrossSalary = $currentSalaryObject->monthly_gross_salary * $paidDays / $totalDays;
                $employeeBasicSalary = $currentSalaryObject->basic_salary * $paidDays / $totalDays;
                $employeeHra = $currentSalaryObject->hra * $paidDays / $totalDays;
                $employeeTransportAllowance = $currentSalaryObject->transport_allowance * $paidDays / $totalDays;
                $employeeOtherAllowance = $currentSalaryObject->other_allowance * $paidDays / $totalDays;
                $employeeFoodAllowance = $currentSalaryObject->food_allowance * $paidDays / $totalDays;
                $employeeSalary = $currentSalaryObject->total_salary * $paidDays / $totalDays;
                $employeeEmployeeEsi = $currentSalaryObject->employee_esi * $paidDays / $totalDays;
                $employeeEmployeeEpf = $currentSalaryObject->employee_epf * $paidDays / $totalDays;
                $employeeTds = $currentSalaryObject->tds * $paidDays / $totalDays;
                $employeeAdvanceRecovery = $employee->loan_deduction_for_month;
                $employeeDeduction = (($currentSalaryObject->employee_esi + $currentSalaryObject->employee_epf + $currentSalaryObject->food_allowance + $currentSalaryObject->tds) * $paidDays / $totalDays) + $currentSalaryObject->employee->loan_deduction_for_month;
                $employeeNetPay = $employeeSalary - $employeeDeduction;
                $employeeEmployerEsi = $currentSalaryObject->employer_esi * $paidDays / $totalDays;
                $employeeEmployerEpf = $currentSalaryObject->employer_epf * $paidDays / $totalDays;
                $employeeAdministrationCharges = $currentSalaryObject->administration_charges * $paidDays / $totalDays;
                $employeeEdliCharges = $currentSalaryObject->edli_charges * $paidDays / $totalDays;
                $employeeCtc = $currentSalaryObject->ctc * $paidDays / $totalDays;
                $employeeCtcAnnual = $currentSalaryObject->ctc_annual;
                $employeeHealthInsurance = $currentSalaryObject->total_health_insurance;
                $employeeCtcAgg = $currentSalaryObject->ctc_aggregated;
            } else {
                $employeeGrossSalary = $currentSalaryObject->monthly_gross_salary;
                $employeeBasicSalary = $currentSalaryObject->basic_salary;
                $employeeHra = $currentSalaryObject->hra;
                $employeeTransportAllowance = $currentSalaryObject->transport_allowance;
                $employeeOtherAllowance = $currentSalaryObject->other_allowance;
                $employeeFoodAllowance = $currentSalaryObject->food_allowance;
                $employeeSalary = $currentSalaryObject->total_salary;
                $employeeEmployeeEsi = $currentSalaryObject->employee_esi;
                $employeeEmployeeEpf = $currentSalaryObject->employee_epf;
                $employeeTds = $currentSalaryObject->tds;
                $employeeAdvanceRecovery = $employee->loan_deduction_for_month;
                $employeeDeduction = $currentSalaryObject->total_deduction;
                $employeeNetPay = $currentSalaryObject->net_pay;
                $employeeEmployerEsi = $currentSalaryObject->employer_esi;
                $employeeEmployerEpf = $currentSalaryObject->employer_epf;
                $employeeAdministrationCharges = $currentSalaryObject->administration_charges;
                $employeeEdliCharges = $currentSalaryObject->edli_charges;
                $employeeCtc = $currentSalaryObject->ctc;
                $employeeCtcAnnual = $currentSalaryObject->ctc_annual;
                $employeeHealthInsurance = $currentSalaryObject->total_health_insurance;
                $employeeCtcAgg = $currentSalaryObject->ctc_aggregated;
            }

            $totalGrossSalary += $employeeGrossSalary;
            $totalBasicSalary += $employeeBasicSalary;
            $totalHra += $employeeHra;
            $totalTransportAllowance += $employeeTransportAllowance;
            $totalOtherAllowance += $employeeOtherAllowance;
            $totalFoodAllowance += $employeeFoodAllowance;
            $totalSalary += $employeeSalary;
            $totalEmployeeEsi += $employeeEmployeeEsi;
            $totalEmployeeEpf += $employeeEmployeeEpf;
            $totalTds += $employeeTds;
            $totalAdvanceRecovery += $employeeAdvanceRecovery;
            $totalDeduction += $employeeDeduction;
            $totalNetPay += $employeeNetPay;
            $totalEmployerEsi += $employeeEmployerEsi;
            $totalEmployerEpf += $employeeEmployerEpf;
            $totalAdministrationCharges += $employeeAdministrationCharges;
            $totalEdliCharges += $employeeEdliCharges;
            $totalCtc += $employeeCtc;
            $totalCtcAnnual += $employeeCtcAnnual;
            $totalHealthInsurance += $employeeHealthInsurance;
            $totalCtcAgg += $employeeCtcAgg;
            $commentMessage = '';

            if ($currentSalaryObject->commencement_date->startOfDay() === today()->startOfDay()) {
                $commentMessage = 'Salary incremented done on ' . optional($currentSalaryObject->commencement_date)->format('d M Y') . '. ';
            }

            if (optional($employee->termination_date)->startOfDay() === today()->startOfDay()) {
                $commentMessage = 'Employee left on ' . optional($employee->termination_date)->format('d M Y');
            }

            $employeePayrollData = [
                $employee->user()->withTrashed()->first()->name,
                $employee->cc_employee_id,
                optional($employee->hrJobDesignation)->designation,
                $employeeGrossSalary ?? '-',
                $employeeBasicSalary ?? '-',
                $employeeHra ?? '-',
                $employeeTransportAllowance ?? '-',
                $employeeOtherAllowance ?? '-',
                $employeeFoodAllowance ?? '-',
                $employeeSalary ?? '-',
                $daysInMonth,
                $paidDays,
                $employeeEmployeeEsi,
                $employeeEmployeeEpf,
                $employeeTds ?? '-',
                $employeeAdvanceRecovery ?? '-',
                $employeeFoodAllowance ?? '-',
                $employeeDeduction ?? '-',
                '-',
                $employeeNetPay ?? '-',
                $employeeEmployerEsi ?? '-',
                $employeeEmployerEpf ?? '-',
                $employeeAdministrationCharges ?? '-',
                $employeeEdliCharges ?? '-',
                $employeeCtc ?? '-',
                $employeeCtcAnnual ?? '-',
                $employeeHealthInsurance ?? '-',
                $employeeCtcAgg ?? '-',
                $commentMessage,
            ];

            array_push($data, $employeePayrollData);
        }

        array_push($data, [
            [],
            [
                null,
                null,
                null,
                $totalGrossSalary ?: '-',
                $totalBasicSalary ?: '-',
                $totalHra ?: '-',
                $totalTransportAllowance ?: '-',
                $totalOtherAllowance ?: '-',
                $totalFoodAllowance ?: '-',
                $totalSalary ?: '-',
                $totalDays ?: '-',
                $totalPaidDays ?: '-',
                $totalEmployeeEsi ?: '-',
                $totalEmployeeEpf ?: '-',
                $totalTds ?: '-',
                $totalAdvanceRecovery ?: '-',
                $totalFoodAllowance ?: '-',
                $totalDeduction ?: '-',
                '-',
                $totalNetPay ?: '-',
                $totalEmployerEsi ?: '-',
                $totalEmployerEpf ?: '-',
                $totalAdministrationCharges ?: '-',
                $totalEdliCharges ?: '-',
                $totalCtc ?: '-',
                $totalCtcAnnual ?: '-',
                $totalHealthInsurance ?: '-',
                $totalCtcAgg,
                '',
            ],
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Coloredcow Consulting Private Limited'],
            [Carbon::now()->format('F Y'), 'Paid', Carbon::today()->toDateString()],
            ['Employee Name', 'Employee ID', 'Designation', 'GROSS', 'Basic Salary', 'HRA', 'Transport allowance', 'Other Allowance', 'Food Allowance', 'Total Salary', 'Total No of Days', 'Paid Days', 'Employee ESI 0.75%', 'Employee EPF 12 %', 'TDS', 'Advance Recovery', 'Food Deduction', 'Total Deduction', 'Advance Salary', ' Net Pay', ' Employer ESI 3.25%', ' EPF EMPLOYER SHARE 12%', ' Administration charges FIXED 0.5%( BASIC SALARY)', ' EDLI Charges FIXED 0.5%(MAXIMUM SALARY LIMIT 15000)', ' CTC', ' CTC Annual', 'Health Insurance', 'CTC Aggreed', 'Comment'],
        ];
    }

    public function title(): string
    {
        return 'FTE';
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('M2:P2');
        $sheet->setCellValue('M2', 'Deduction');
        $sheet->mergeCells('U2:X2');
        $sheet->setCellValue('U2', ' Employer Contribution');

        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
            2 => [
                'font' => [
                    'bold' => true,
                ],
            ],
            3 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}
