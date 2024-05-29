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
        $totalDays = $this->employees->count() * 30;
        $totalPaidDays = $this->employees->count() * 30;
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
            $totalGrossSalary += optional($employee->getCurrentSalary())->monthly_gross_salary;
            $totalBasicSalary += optional($employee->getCurrentSalary())->basic_salary;
            $totalHra += optional($employee->getCurrentSalary())->hra;
            $totalTransportAllowance += optional($employee->getCurrentSalary())->transport_allowance;
            $totalOtherAllowance += optional($employee->getCurrentSalary())->other_allowance;
            $totalFoodAllowance += optional($employee->getCurrentSalary())->food_allowance;
            $totalSalary += optional($employee->getCurrentSalary())->total_salary;
            $totalEmployeeEsi += optional($employee->getCurrentSalary())->employee_esi;
            $totalEmployeeEpf += optional($employee->getCurrentSalary())->employee_epf;
            $totalTds += optional($employee->getCurrentSalary())->tds;
            $totalAdvanceRecovery += $employee->loan_deduction_for_month;
            $totalDeduction += optional($employee->getCurrentSalary())->total_deduction;
            $totalNetPay += optional($employee->getCurrentSalary())->net_pay;
            $totalEmployerEsi += optional($employee->getCurrentSalary())->employer_esi;
            $totalEmployerEpf += optional($employee->getCurrentSalary())->employer_epf;
            $totalAdministrationCharges += optional($employee->getCurrentSalary())->administration_charges;
            $totalEdliCharges += optional($employee->getCurrentSalary())->edli_charges;
            $totalCtc += optional($employee->getCurrentSalary())->ctc;
            $totalCtcAnnual += optional($employee->getCurrentSalary())->ctc_annual;
            $totalHealthInsurance += optional($employee->getCurrentSalary())->total_health_insurance;
            $totalCtcAgg += optional($employee->getCurrentSalary())->ctc_aggregated;

            $employeePayrollData = [
                $employee->user()->withTrashed()->first()->name,
                $employee->cc_employee_id,
                optional($employee->hrJobDesignation)->designation,
                optional($employee->getCurrentSalary())->monthly_gross_salary ?: '-',
                optional($employee->getCurrentSalary())->basic_salary ?: '-',
                optional($employee->getCurrentSalary())->hra ?: '-',
                optional($employee->getCurrentSalary())->transport_allowance ?: '-',
                optional($employee->getCurrentSalary())->other_allowance ?: '-',
                optional($employee->getCurrentSalary())->food_allowance ?: '-',
                optional($employee->getCurrentSalary())->total_salary ?: '-',
                30,
                30,
                optional($employee->getCurrentSalary())->employee_esi,
                optional($employee->getCurrentSalary())->employee_epf,
                optional($employee->getCurrentSalary())->tds ?: '-',
                $employee->loan_deduction_for_month ?: '-',
                optional($employee->getCurrentSalary())->food_allowance ?: '-',
                optional($employee->getCurrentSalary())->total_deduction ?: '-',
                '-',
                optional($employee->getCurrentSalary())->net_pay ?: '-',
                optional($employee->getCurrentSalary())->employer_esi ?: '-',
                optional($employee->getCurrentSalary())->employer_epf ?: '-',
                optional($employee->getCurrentSalary())->administration_charges ?: '-',
                optional($employee->getCurrentSalary())->edli_charges ?: '-',
                optional($employee->getCurrentSalary())->ctc ?: '-',
                optional($employee->getCurrentSalary())->ctc_annual ?: '-',
                optional($employee->getCurrentSalary())->total_health_insurance ?: '-',
                optional($employee->getCurrentSalary())->ctc_aggregated ?: '-',
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
            ],
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Coloredcow Consulting Private Limited'],
            [Carbon::now()->format('F Y'), 'Paid', Carbon::today()->toDateString()],
            ['Employee Name', 'Employee ID', 'Designation', 'GROSS', 'Basic Salary', 'HRA', 'Transport allowance', 'Other Allowance', 'Food Allowance', 'Total Salary', 'Total No of Days', 'Paid Days', 'Employee ESI 0.75%', 'Employee EPF 12 %', 'TDS', 'Advance Recovery', 'Food Deduction', 'Total Deduction', 'Advance Salary', ' Net Pay', ' Employer ESI 3.25%', ' EPF EMPLOYER SHARE 12%', ' Administration charges FIXED 0.5%( BASIC SALARY)', ' EDLI Charges FIXED 0.5%(MAXIMUM SALARY LIMIT 15000)', ' CTC', ' CTC Annual', 'Health Insurance', 'CTC Aggreed'],
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
