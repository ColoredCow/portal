<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
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

    public function dashboard()
    {
        return view('report::finance.dashboard');
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

        return view('report::finance.profit-and-loss', ['reportData' => $reportData, 'currentYear' => $currentYear, 'allAmounts' => $allAmounts]);
    }

    public function getReportData(Request $request)
    {
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
