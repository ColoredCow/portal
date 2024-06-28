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
    protected $contractorsRowCount = 0;

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

            $isContractorLeavingThisMonth = optional($contractor->termination_date)->isSameMonth(today());

            $totalDays += $daysInMonth;

            if ($isContractorLeavingThisMonth) {
                $paidDays = $contractor->termination_date->day;
                $contractorMonthlyFee = $currentSalaryObject->monthly_fee * $paidDays / $daysInMonth;
                $contractorTds = $currentSalaryObject->monthly_fee * $paidDays / $daysInMonth;
                $contractorAdvanceFee = $contractor->loan_deduction_for_month;
                $contractorDeduction = $contractor->loan_deduction_for_month + ($currentSalaryObject->monthly_fee * $paidDays / $daysInMonth);
                $contractorNetPay = $contractorMonthlyFee - $contractorDeduction;
                $contractorCtcAnnual = optional($currentSalaryObject)->ctc_annual;
                $contractorCtcAgg = optional($currentSalaryObject)->ctc_aggregated;
            } else {
                $paidDays = $daysInMonth;
                $contractorMonthlyFee = $currentSalaryObject->monthly_fee;
                $contractorTds = $currentSalaryObject->tds;
                $contractorAdvanceFee = $contractor->loan_deduction_for_month;
                $contractorDeduction = optional($currentSalaryObject)->total_deduction;
                $contractorNetPay = optional($currentSalaryObject)->net_pay;
                $contractorCtcAnnual = optional($currentSalaryObject)->ctc_annual;
                $contractorCtcAgg = optional($currentSalaryObject)->ctc_aggregated;
            }

            $totalPaidDays += $paidDays;
            $totalFee += $contractorMonthlyFee;
            $totalTds += $contractorTds;
            $totalAdvanceFee += $contractorAdvanceFee;
            $totalDeduction += $contractorDeduction;
            $totalNetPay += $contractorNetPay;
            $totalCtcAnnual += $contractorCtcAnnual;
            $totalCtcAgg += $contractorCtcAgg;

            $commentMessage = '';

            if ($currentSalaryObject->commencement_date->isSameMonth(today())) {
                $commentMessage = 'Salary incremented done on ' . optional($currentSalaryObject->commencement_date)->format('d M Y') . '. ';
            }

            if (optional($contractor->termination_date)->isSameMonth(today())) {
                $commentMessage = 'Contractor left on ' . optional($contractor->termination_date)->format('d M Y');
            }

            $contractorPayrollData = [
                $contractor->user()->withTrashed()->first()->name,
                'Consultant',
                $contractorMonthlyFee ?: '-',
                $daysInMonth,
                $paidDays,
                $contractorTds ?? '-',
                $contractorAdvanceFee ?? '-',
                $contractorDeduction ?? '-',
                '-',
                $contractorNetPay ?? '-',
                $contractorMonthlyFee ?? '-',
                $contractorCtcAnnual ?? '-',
                $contractorCtcAgg ?? '-',
                $commentMessage,
            ];

            array_push($data, $contractorPayrollData);
            $this->contractorsRowCount++;
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
                null,
            ],
        ]);

        $this->contractorsRowCount += 2;

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Coloredcow Consulting Private Limited'],
            [now()->format('F Y'), 'Paid', today()->toDateString()],
            [
            'Contractor Name', 'Designation', 'Total Fee', 'Total No of Days', 'Paid Days', 'TDS', 'Advance Recovery', 'Total Deduction', 'Advance Fee', 'Net Pay', 'Monthly Fee', 'CTC Annual', 'CTC Aggreed', 'Comment',
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
        $lastRow = $this->contractorsRowCount + 3;

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
            $lastRow => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}
