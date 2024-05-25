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
        $totalDays = $this->contractors->count() * 30;
        $totalPaidDays = $this->contractors->count() * 30;
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
            $totalGrossSalary += optional($contractor->getCurrentSalary())->monthly_gross_salary;
            $totalBasicSalary += optional($contractor->getCurrentSalary())->basic_salary;
            $totalHra += optional($contractor->getCurrentSalary())->hra;
            $totalTransportAllowance += optional($contractor->getCurrentSalary())->transport_allowance;
            $totalOtherAllowance += optional($contractor->getCurrentSalary())->other_allowance;
            $totalFoodAllowance += optional($contractor->getCurrentSalary())->food_allowance;
            $totalSalary += optional($contractor->getCurrentSalary())->total_salary;
            $totalEmployeeEsi += optional($contractor->getCurrentSalary())->employee_esi;
            $totalEmployeeEpf += optional($contractor->getCurrentSalary())->employee_epf;
            $totalTds += optional($contractor->getCurrentSalary())->tds;
            $totalAdvanceRecovery += $contractor->loan_deduction_for_month;
            $totalDeduction += optional($contractor->getCurrentSalary())->total_deduction;
            $totalNetPay += optional($contractor->getCurrentSalary())->net_pay;
            $totalEmployerEsi += optional($contractor->getCurrentSalary())->employer_esi;
            $totalEmployerEpf += optional($contractor->getCurrentSalary())->employer_epf;
            $totalAdministrationCharges += optional($contractor->getCurrentSalary())->administration_charges;
            $totalEdliCharges += optional($contractor->getCurrentSalary())->edli_charges;
            $totalCtc += optional($contractor->getCurrentSalary())->ctc;
            $totalCtcAnnual += optional($contractor->getCurrentSalary())->ctc_annual;
            $totalHealthInsurance += optional($contractor->getCurrentSalary())->total_health_insurance;
            $totalCtcAgg += optional($contractor->getCurrentSalary())->ctc_aggregated;

            $contractorPayrollData = [
                $contractor->user()->withTrashed()->first()->name,
                "",
                "Consultant",
                optional($contractor->getCurrentSalary())->monthly_gross_salary ?: '-',
                optional($contractor->getCurrentSalary())->basic_salary ?: '-',
                optional($contractor->getCurrentSalary())->hra ?: '-',
                optional($contractor->getCurrentSalary())->transport_allowance ?: '-',
                optional($contractor->getCurrentSalary())->other_allowance ?: '-',
                optional($contractor->getCurrentSalary())->food_allowance ?: '-',
                optional($contractor->getCurrentSalary())->total_salary ?: '-',
                30,
                30,
                optional($contractor->getCurrentSalary())->employee_esi,
                optional($contractor->getCurrentSalary())->employee_epf,
                optional($contractor->getCurrentSalary())->tds ?: '-',
                $contractor->loan_deduction_for_month ?: '-',
                optional($contractor->getCurrentSalary())->food_allowance ?: '-',
                optional($contractor->getCurrentSalary())->total_deduction ?: '-',
                '-',
                optional($contractor->getCurrentSalary())->net_pay ?: '-',
                optional($contractor->getCurrentSalary())->employer_esi ?: '-',
                optional($contractor->getCurrentSalary())->employer_epf ?: '-',
                optional($contractor->getCurrentSalary())->administration_charges ?: '-',
                optional($contractor->getCurrentSalary())->edli_charges ?: '-',
                optional($contractor->getCurrentSalary())->ctc ?: '-',
                optional($contractor->getCurrentSalary())->ctc_annual ?: '-',
                optional($contractor->getCurrentSalary())->total_health_insurance ?: '-',
                optional($contractor->getCurrentSalary())->ctc_aggregated ?: '-',
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
