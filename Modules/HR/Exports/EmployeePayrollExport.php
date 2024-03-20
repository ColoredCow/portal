<?php

namespace Modules\HR\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;

class EmployeePayrollExport implements FromArray, WithHeadings, ShouldAutoSize, WithTitle, WithStyles
{
    // protected $employees;

    public function __construct()
    {
        // $this->employees = $employees;
    }

    public function array(): array
    {
        return [['hello']];
    }

    public function headings(): array
    {
        return [
            ['Coloredcow Consulting Private Limited'],
            [Carbon::now()->format('F Y'), "Paid", Carbon::today()->toDateString()],
            ["Employee Name", "Employee ID","Designation", "GROSS", "Basic Salary", "HRA", "Transport allowance", "Other Allowance","Food Allowance", "Total Salary", "Total No of Days", "Paid Days", "Employee ESI 0.75%", "Employee EPF 12 %", "TDS","Advance Recovery", "Food Deduction","Total Deduction", "Advance Salary", " Net Pay", " Employer ESI 3.25%", " EPF EMPLOYER SHARE 12%", " Administration charges FIXED 0.5%( BASIC SALARY)", " EDLI Charges FIXED 0.5%(MAXIMUM SALARY LIMIT 15000)", " CTC", " CTC Annual", "Health Insurance", "CTC Agreed"]
        ];
    }

    public function exportData()
    {
        $data = [
            'hello'
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
    }
}
