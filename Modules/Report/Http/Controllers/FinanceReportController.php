<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Report\Services\Finance\ProfitAndLossReportService;

class FinanceReportController extends Controller
{
    protected $service;

    public function __construct(ProfitAndLossReportService $service)
    {
        $this->service = $service;
    }

    public function profitAndLoss()
    {
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
}
