<?php

namespace Modules\Report\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProfitAndLossReportExport implements FromArray, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        return $this->reportData;
    }

    public function headings(): array
    {
        $currentYear = date('m') > 03 ? date('Y') + 1 : date('Y');
        $startYear = request()->input('year', $currentYear);
        $lastYear = $startYear - 1;
        $startYearVal = substr($startYear, -2);
        $lastYearVal = substr((string) $lastYear, -2);

            return [
                'Head',
                'Particulars',
                'Total',
                "Apr-$lastYearVal",
                "May-$lastYearVal",
                "Jun-$lastYearVal",
                "Jul-$lastYearVal",
                "Aug-$lastYearVal",
                "Sep-$lastYearVal",
                "Oct-$lastYearVal",
                "Nov-$lastYearVal",
                "Dec-$lastYearVal",
                "Jan-$startYearVal",
                "Feb-$startYearVal",
                "Mar-$startYearVal",
            ];
    }

    public function title(): string
    {
        return 'Profit And Loss Report Data';
    }
}
