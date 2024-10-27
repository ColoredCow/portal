<?php
namespace Modules\Report\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProfitAndLossReportExport implements FromArray, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $currentYear;
    protected $startYear;
    protected $lastYear;
    protected $startYearVal;
    protected $lastYearVal;
    protected $reportData;

    public function __construct($reportData)
    {
        $this->currentYear = date('m') > 03 ? date('Y') + 1 : date('Y');
        $this->startYear = request()->input('year', $this->currentYear);
        $this->lastYear = $this->startYear - 1;
        $this->startYearVal = substr($this->startYear, -2);
        $this->lastYearVal = substr((string) $this->lastYear, -2);

        $this->reportData = $this->formatProfitAndLossForExportAll($reportData);
    }

    public function array(): array
    {
        return $this->reportData;
    }

    public function headings(): array
    {
        return [
                'Head',
                'Particulars',
                'Total',
                "Apr-{$this->lastYearVal}",
                "May-{$this->lastYearVal}",
                "Jun-{$this->lastYearVal}",
                "Jul-{$this->lastYearVal}",
                "Aug-{$this->lastYearVal}",
                "Sep-{$this->lastYearVal}",
                "Oct-{$this->lastYearVal}",
                "Nov-{$this->lastYearVal}",
                "Dec-{$this->lastYearVal}",
                "Jan-{$this->startYearVal}",
                "Feb-{$this->startYearVal}",
                "Mar-{$this->startYearVal}",
            ];
    }

    public function title(): string
    {
        return 'Profit And Loss Report Data';
    }

    public function formatProfitAndLossForExportAll($reportData)
    {
        $allAmounts = array_map(function ($item) {
            return $item['amounts'];
        }, $reportData);

        $profitAndLossData = [];
        foreach ($reportData as $perticular) {
            $profitAndLoss = [
                $perticular['head'],
                $perticular['name'],
                $perticular['amounts']['total'] ?? number_format(0),
                $perticular['amounts']["04-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["05-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["06-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["07-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["08-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["09-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["10-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["11-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["12-{$this->lastYearVal}"] ?? 0,
                $perticular['amounts']["01-{$this->startYearVal}"] ?? 0,
                $perticular['amounts']["02-{$this->startYearVal}"] ?? 0,
                $perticular['amounts']["03-{$this->startYearVal}"] ?? 0,
            ];
            $profitAndLossData[] = $profitAndLoss;
        }
        $profitAndLoss = ['Total Revenue', null, array_sum(array_column($allAmounts, 'total')),
            array_sum(array_column($allAmounts, "04-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "05-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "06-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "07-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "08-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "09-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "10-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "11-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "12-{$this->lastYearVal}")),
            array_sum(array_column($allAmounts, "01-{$this->startYearVal}")),
            array_sum(array_column($allAmounts, "02-{$this->startYearVal}")),
            array_sum(array_column($allAmounts, "03-{$this->startYearVal}")),
        ];
        $profitAndLossData[] = $profitAndLoss;

        return $profitAndLossData;
    }
}
