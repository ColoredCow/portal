<?php

namespace Modules\Report\Services\Finance;

use Modules\Client\Entities\Client;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class ReportDataService
{
    public function getData($type, $filters)
    {
        if ($type == 'revenue-trend') {
            return $this->revenueTrend($filters);
        }

        if ($type == 'revenue-trend-client-wise') {
            return $this->revenueTrendForClient($filters);
        }

        return $filters;
    }

    public function getDataForDailyCodeTrekApplications($type, $filters, $request)
    {
        if ($type == 'codetrek-application') {
            $applicants = CodeTrekApplicant::find('start_date');
            $defaultStartDate = $applicants->created_at ?? today()->subYear();
            $defaultEndDate = today();
            $filters['start_date'] = empty($filters['start_date']) ? $defaultStartDate : $filters['start_date'];
            $filters['end_date'] = empty($filters['end_date']) ? $defaultEndDate : $filters['end_date'];
            $applicantChartData = CodeTrekApplicant::select(\DB::Raw('DATE(start_date) as date, COUNT(*) as count'))
                ->whereDate('start_date', '>=', $filters['start_date'])
                ->whereDate('start_date', '<=', $filters['end_date'])
                ->groupBy('date');

            $dates = $applicantChartData->pluck('date')->toArray();
            $counts = $applicantChartData->pluck('count')->toArray();
            $chartData = [
                'dates' => $dates,
                'counts' => $counts,
            ];
            $reportApplicantData = json_encode($chartData);

            return $reportApplicantData;
        }
    }

    public function getDataForClientRevenueReportPage(array $data)
    {
        $selectedClient = isset($data['client_id']) ? Client::find($data['client_id']) : Client::orderBy('name')->first();

        return [
            'selectedClient' => $selectedClient,
            'clients' => Client::orderBy('name')->get()
        ];
    }

    private function revenueTrendForClient($filters)
    {
        $client = Client::find($filters['client_id']);
        $defaultStartDate = $client->created_at ?? $client->invoices()->orderBy('sent_on')->first()->sent_on;
        $defaultEndDate = today();

        $filters['start_date'] = empty($filters['start_date']) ? $defaultStartDate : $filters['start_date'];
        $filters['end_date'] = empty($filters['end_date']) ? $defaultEndDate : $filters['end_date'];

        $reportData = $this->service->getRevenueReportDataForClient($filters, $client);

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

        $reportData = $this->service->getRevenueGroupedByClient($filters);

        return [
            'labels' => $reportData['clients_name'],
            'data' => $reportData,
        ];
    }
}
