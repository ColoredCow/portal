<?php

namespace Modules\Report\Services\Finance;

use Modules\Client\Entities\Client;

class ReportDataService
{
    public function getData($type, $filters)
    {
        if ($type == 'revenue-trend') {
            return $this->revenueTrend($filters);
        } elseif ($type == 'revenue-trend-client-wise') {
            return $this->revenueTrendForClient($filters);
        }

        return $filters;
    }

    private function revenueTrendForClient($filters)
    {
        $client = Client::find($filters['client_id']);
        $defaultStartDate = $client->created_at ?? $client->invoices()->orderBy('sent_on')->first()->sent_on;
        $defaultEndDate = today();

        $filters['start_date'] = $defaultStartDate;
        $filters['end_date'] = $defaultEndDate;

        $reportData = app(RevenueReportService::class)->getRevenueForClient($filters, $client);

        return [
            'labels' => $reportData['months'],
            'data' => $reportData
        ];
    }

    private function revenueTrend($filters)
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

        $reportData = app(RevenueReportService::class)->getRevenueGroupedByClient($filters);

        return [
            'labels' => $reportData['clients_name'],
            'data' => $reportData,
        ];
    }
}
