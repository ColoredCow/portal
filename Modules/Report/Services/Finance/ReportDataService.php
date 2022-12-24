<?php

namespace Modules\Report\Services\Finance;

class ReportDataService
{
    public function getData($type, $filters)
    {
        if ($type == 'revenue-trend') {
            return $this->revenueTrend();
        }

        return $filters;
    }

    private function revenueTrend()
    {
        $defaultStartDate = today()->startOfMonth();
        $defaultEndDate = today()->endOfMonth();
        $defaultPreviousStartDate = today()->subMonth()->startOfMonth();
        $defaultPreviousEndDate = today()->subMonth()->endOfMonth();
        $defaultFilters = [
            'transaction' => 'revenue',
            'current_period_start_date' => $defaultStartDate,
            'current_period_end_date' => $defaultEndDate,
            'previous_period_start_date' => $defaultPreviousStartDate,
            'previous_period_end_date' => $defaultPreviousEndDate
        ];
        $filters = array_merge($defaultFilters, request()->all());

        $reportData = app(RevenueReportService::class)->getClientWiseRevenue($filters);

        return [
            'labels' => $reportData['clients_name'],
            'data' => $reportData
        ];
    }
}
