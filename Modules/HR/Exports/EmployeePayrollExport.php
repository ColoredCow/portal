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
        foreach ($this->employees as $employee) {
            $employeePayrollData = [
                $employee->user()->withTrashed()->first()->name,
                $employee->cc_employee_id,
                optional($employee->hrJobDesignation)->designation,
                optional($employee->getCurrentSalary())->monthly_gross_salary,
                optional($employee->getCurrentSalary())->basic_salary,
                optional($employee->getCurrentSalary())->hra,
                optional($employee->getCurrentSalary())->transport_allowance,
                optional($employee->getCurrentSalary())->other_allowance,
                optional($employee->getCurrentSalary())->food_allowance,
                optional($employee->getCurrentSalary())->total_salary,
                30,
                30,
                optional($employee->getCurrentSalary())->employee_esi,
                optional($employee->getCurrentSalary())->employee_epf,
                null,
                null,
                optional($employee->getCurrentSalary())->food_allowance,
                optional($employee->getCurrentSalary())->total_deduction,
                null,
                optional($employee->getCurrentSalary())->net_pay,
                optional($employee->getCurrentSalary())->employer_esi,
                optional($employee->getCurrentSalary())->employer_epf,
                optional($employee->getCurrentSalary())->administration_charges,
                optional($employee->getCurrentSalary())->edli_charges,
                optional($employee->getCurrentSalary())->ctc,
                optional($employee->getCurrentSalary())->ctc_annual,
                optional($employee->getCurrentSalary())->health_insurance,
                optional($employee->getCurrentSalary())->ctc_aggregated,
            ];

            array_push($data, $employeePayrollData);
        }

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
