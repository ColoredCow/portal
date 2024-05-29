<?php

namespace Modules\HR\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractorFeeExport implements FromArray, WithHeadings, ShouldAutoSize, WithTitle, WithStyles
{
    protected $contractors;

    public function __construct($contractors)
    {
        $this->contractors = $contractors;
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
        $totalDays = $this->contractors->count() * $daysInMonth;
        $totalPaidDays = $this->contractors->count() * $daysInMonth;
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

        foreach ($this->contractors as $contractor) {
            $currentSalaryObject = $contractor->getCurrentSalary();
            
            if (! $currentSalaryObject) {
                continue;
            }

            $totalGrossSalary += optional($currentSalaryObject)->monthly_gross_salary;
            $totalBasicSalary += optional($currentSalaryObject)->basic_salary;
            $totalHra += optional($currentSalaryObject)->hra;
            $totalTransportAllowance += optional($currentSalaryObject)->transport_allowance;
            $totalOtherAllowance += optional($currentSalaryObject)->other_allowance;
            $totalFoodAllowance += optional($currentSalaryObject)->food_allowance;
            $totalSalary += optional($currentSalaryObject)->total_salary;
            $totalEmployeeEsi += optional($currentSalaryObject)->employee_esi;
            $totalEmployeeEpf += optional($currentSalaryObject)->employee_epf;
            $totalTds += optional($currentSalaryObject)->tds;
            $totalAdvanceRecovery += $contractor->loan_deduction_for_month;
            $totalDeduction += optional($currentSalaryObject)->total_deduction;
            $totalNetPay += optional($currentSalaryObject)->net_pay;
            $totalEmployerEsi += optional($currentSalaryObject)->employer_esi;
            $totalEmployerEpf += optional($currentSalaryObject)->employer_epf;
            $totalAdministrationCharges += optional($currentSalaryObject)->administration_charges;
            $totalEdliCharges += optional($currentSalaryObject)->edli_charges;
            $totalCtc += optional($currentSalaryObject)->ctc;
            $totalCtcAnnual += optional($currentSalaryObject)->ctc_annual;
            $totalHealthInsurance += optional($currentSalaryObject)->total_health_insurance;
            $totalCtcAgg += optional($currentSalaryObject)->ctc_aggregated;

            $contractorPayrollData = [
                $contractor->user()->withTrashed()->first()->name,
                '',
                'Consultant',
                optional($currentSalaryObject)->monthly_gross_salary ?: '-',
                optional($currentSalaryObject)->basic_salary ?: '-',
                optional($currentSalaryObject)->hra ?: '-',
                optional($currentSalaryObject)->transport_allowance ?: '-',
                optional($currentSalaryObject)->other_allowance ?: '-',
                optional($currentSalaryObject)->food_allowance ?: '-',
                optional($currentSalaryObject)->total_salary ?: '-',
                $daysInMonth,
                $daysInMonth,
                optional($currentSalaryObject)->employee_esi,
                optional($currentSalaryObject)->employee_epf,
                optional($currentSalaryObject)->tds ?: '-',
                $contractor->loan_deduction_for_month ?: '-',
                optional($currentSalaryObject)->food_allowance ?: '-',
                optional($currentSalaryObject)->total_deduction ?: '-',
                '-',
                optional($currentSalaryObject)->net_pay ?: '-',
                optional($currentSalaryObject)->employer_esi ?: '-',
                optional($currentSalaryObject)->employer_epf ?: '-',
                optional($currentSalaryObject)->administration_charges ?: '-',
                optional($currentSalaryObject)->edli_charges ?: '-',
                optional($currentSalaryObject)->ctc ?: '-',
                optional($currentSalaryObject)->ctc_annual ?: '-',
                optional($currentSalaryObject)->total_health_insurance ?: '-',
                optional($currentSalaryObject)->ctc_aggregated ?: '-',
            ];

            array_push($data, $contractorPayrollData);
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
