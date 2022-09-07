<?php

namespace Modules\Report\Services\Finance;

class ReportDataService
{
    public function getData($type, $filters)
    {
        switch($type) {
            case 'revenue-trend':
                return $this->revenueTrend();
                break;
        }
    }

    private function revenueTrend()
    {
        $currentYear = date('m') > 03 ? date('Y') + 1 : date('Y');
        $defaultFilters = [
            'transaction' => 'revenue',
            'year' => $currentYear,
        ];

        $filters = array_merge($defaultFilters, request()->all());
        $reportData = app(ProfitAndLossReportService::class)->profitAndLoss($filters);

        $monthlyData = [];

        foreach ($reportData as $revenueHead) {
            foreach ($revenueHead['amounts'] as $key => $amount) {
                dd($key, $amount);
            }
        }

        $labels = [
            'April (2022)',
            'May (2022)',
            'June (2022)',
            'July (2022)',
            'August (2022)',
            'September (2022)',
            'October (2022)',
            'November (2022)',
            'December (2022)',
            'January (2023)',
            'February (2023)',
            'March (2023)',
          ];

        $data = [20, 12, 15, 20, 23, 35, 40, 45, 48, 52, 55, 58];

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
