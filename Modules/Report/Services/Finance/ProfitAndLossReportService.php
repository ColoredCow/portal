<?php

namespace Modules\Report\Services\Finance;

use Modules\Report\Exports\ProfitAndLossReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ProfitAndLossReportService
{
    public function profitAndLoss(array $filters): array
    {
        $transaction = $filters['transaction'];
        $year = $filters['year'];

        $startYear = $year - 1;
        $endYear = $year;

        if ($transaction == 'revenue') {
            return app(RevenueReportService::class)->getAllParticulars($startYear, $endYear);
        }

        return [];
    }

    public function profitAndLossReportExport()
    {
        $currentYear = date('m') > 03 ? date('Y') + 1 : date('Y');
        $defaultFilters = [
            'transaction' => 'revenue',
            'year' => $currentYear,
        ];

        $filters = array_merge($defaultFilters, request()->all());
        $reportData = $this->profitAndLoss($filters);
        $reportData = $this->formatProfitAndLossForExportAll($reportData);
        $request = request()->all();
        $endYear = $request["year"];
        $startYear = $endYear - 1;
        
        return Excel::download(new ProfitAndLossReportExport($reportData), "Profit And Loss Report $startYear-$endYear.xlsx");
    }

    private function formatProfitAndLossForExportAll($reportData)
    {
        $currentYear = date('m') > 03 ? date('Y') + 1 : date('Y');
        $startYear = request()->input('year', $currentYear);
        $lastYear = $startYear - 1;
        $startYearVal = substr($startYear, -2);
        $lastYearVal = substr((string) $lastYear, -2);
        $allAmounts = array_map(function ($item) {
            return $item['amounts'];
        }, $reportData);

        $profitAndLossData = [];
        foreach ($reportData as $perticular) {
            $profitAndLoss = [
                $perticular['head'],
                $perticular['name'],
                $perticular['amounts']['total'] ?? number_format(0),
                $perticular['amounts']["04-$lastYearVal"] ?? 0,
                $perticular['amounts']["05-$lastYearVal"] ?? 0,
                $perticular['amounts']["06-$lastYearVal"] ?? 0,
                $perticular['amounts']["07-$lastYearVal"] ?? 0,
                $perticular['amounts']["08-$lastYearVal"] ?? 0,
                $perticular['amounts']["09-$lastYearVal"] ?? 0,
                $perticular['amounts']["10-$lastYearVal"] ?? 0,
                $perticular['amounts']["11-$lastYearVal"] ?? 0,
                $perticular['amounts']["12-$lastYearVal"] ?? 0,
                $perticular['amounts']["01-$startYearVal"] ?? 0,
                $perticular['amounts']["02-$startYearVal"] ?? 0,
                $perticular['amounts']["03-$startYearVal"] ?? 0
            ];
            $profitAndLossData[] = $profitAndLoss;
        }
        $profitAndLoss = ['Total Revenue', null, array_sum(array_column($allAmounts, 'total')),
            array_sum(array_column($allAmounts, "04-$lastYearVal")),
            array_sum(array_column($allAmounts, "05-$lastYearVal")),
            array_sum(array_column($allAmounts, "06-$lastYearVal")),
            array_sum(array_column($allAmounts, "07-$lastYearVal")),
            array_sum(array_column($allAmounts, "08-$lastYearVal")),
            array_sum(array_column($allAmounts, "09-$lastYearVal")),
            array_sum(array_column($allAmounts, "10-$lastYearVal")),
            array_sum(array_column($allAmounts, "11-$lastYearVal")),
            array_sum(array_column($allAmounts, "12-$lastYearVal")),
            array_sum(array_column($allAmounts, "01-$startYearVal")),
            array_sum(array_column($allAmounts, "02-$startYearVal")),
            array_sum(array_column($allAmounts, "03-$startYearVal"))
        ];
        $profitAndLossData[] = $profitAndLoss;

        return $profitAndLossData;
    }
}
