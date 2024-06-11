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
        $totalFee = 0;
        $daysInMonth = Carbon::now()->daysInMonth;
        $totalDays = 0;
        $totalPaidDays = 0;
        $totalTds = 0;
        $totalAdvanceFee = 0;
        $totalDeduction = 0;
        $totalNetPay = 0;
        $totalCtcAnnual = 0;
        $totalCtcAgg = 0;

        foreach ($this->contractors as $contractor) {
            $currentSalaryObject = $contractor->getCurrentSalary();

            if (! $currentSalaryObject) {
                continue;
            }

            $totalDays += $daysInMonth;
            $totalPaidDays += $daysInMonth;
            $totalFee += optional($currentSalaryObject)->monthly_fee;
            $totalTds += optional($currentSalaryObject)->tds;
            $totalAdvanceFee += $contractor->loan_deduction_for_month;
            $totalDeduction += optional($currentSalaryObject)->total_deduction;
            $totalNetPay += optional($currentSalaryObject)->net_pay;
            $totalCtcAnnual += optional($currentSalaryObject)->ctc_annual;
            $totalCtcAgg += optional($currentSalaryObject)->ctc_aggregated;

            $contractorPayrollData = [
                $contractor->user()->withTrashed()->first()->name,
                'Consultant',
                optional($currentSalaryObject)->monthly_fee ?: '-',
                $daysInMonth,
                $daysInMonth,
                optional($currentSalaryObject)->tds ?: '-',
                $contractor->loan_deduction_for_month ?: '-',
                optional($currentSalaryObject)->total_deduction ?: '-',
                '-',
                optional($currentSalaryObject)->net_pay ?: '-',
                optional($currentSalaryObject)->monthly_fee ?: '-',
                optional($currentSalaryObject)->ctc_annual ?: '-',
                optional($currentSalaryObject)->ctc_aggregated ?: '-',
            ];

            array_push($data, $contractorPayrollData);
        }

        array_push($data, [
            [],
            [
                null,
                null,
                $totalFee ?: '-',
                $totalDays ?: '-',
                $totalPaidDays ?: '-',
                $totalTds ?: '-',
                $totalAdvanceFee ?: '-',
                $totalDeduction ?: '-',
                '-',
                $totalNetPay ?: '-',
                $totalFee ?: '-',
                $totalCtcAnnual ?: '-',
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
            [
            'Contractor Name', 'Designation', 'Total Fee', 'Total No of Days', 'Paid Days', 'TDS', 'Advance Recovery', 'Total Deduction', 'Advance Fee', 'Net Pay', 'Monthly Fee', 'CTC Annual', 'CTC Aggreed'
            ],
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
