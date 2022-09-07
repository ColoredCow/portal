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
                $monthlyData[$key] = ($monthlyData[$key] ?? 0) + $amount;
            }
        }

        unset($monthlyData['total']);

        $labels = [
            '04-22' => 'April (2022)',
            '05-22' => 'May (2022)',
            '06-22' => 'June (2022)',
            '07-22' => 'July (2022)',
            '08-22' => 'August (2022)',
            '09-22' => 'September (2022)',
            '10-22' => 'October (2022)',
            '11-22' => 'November (2022)',
            '12-22' => 'December (2022)',
            '01-23' => 'January (2023)',
            '02-23' => 'February (2023)',
            '03-23' => 'March (2023)',
          ];

        $data = [];

        foreach ($labels as $key => $label) {
            $data[] = $monthlyData[$key] ?? 0;
        }

        return [
            'labels' => array_values($labels),
            'data' => $data
        ];
    }
}
