<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Report\Services\Finance\ProfitAndLossReportService;

class FinanceReportController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(ProfitAndLossReportService $service)
    {
        $this->service = $service;
    }

    /**
     * Main function to fetch the P&L report.
     */
    public function profitAndLoss()
    {
        $this->authorize('finance_reports.view');
        $currentYear = date('m') > 03 ? date('Y') + 1 : date('Y');
        $defaultFilters = [
            'transaction' => 'revenue',
            'year' => $currentYear,
        ];

        $filters = array_merge($defaultFilters, request()->all());
        $reportData = $this->service->profitAndLoss($filters);

        $allAmounts = array_map(function ($item) {
            return $item['amounts'];
        }, $reportData);

        return view('report::finance.profit-and-loss')->with([
            'reportData' => $reportData,
            'currentYear' => $currentYear,
            'allAmounts' => $allAmounts
        ]);
    }
}
