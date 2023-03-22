<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Report\Services\Finance\ClientRevenueReportService;

class ClientRevenueReportController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(ClientRevenueReportService $service)
    {
        $this->service = $service;
    }

    public function detailed()
    {
        $currentYear = date('m') > 03 ? date('Y') + 1 : date('Y');

        $filters = $this->filters($currentYear);
        $reportData = $this->service->clientWiseRevenue($filters);

        $allAmounts = array_map(function ($item) {
            return $item['amounts'];
        }, $reportData);

        return view('report::finance.client-wise-revenue.detailed', [
            'reportData' => $reportData,
            'currentYear' => $currentYear,
            'allAmounts' => $allAmounts
        ]);
    }

    public function filters($currentYear)
    {
        $defaultFilters = [
            'year' => $currentYear,
        ];

        return array_merge($defaultFilters, request()->all());
    }
}
