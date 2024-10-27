<?php
namespace Modules\Report\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Report\Services\Finance\ProfitAndLossReportService;
use Modules\Report\Services\Finance\ReportDataService;

class FinanceReportController extends Controller
{
    use AuthorizesRequests;

    protected $service;
    protected $reportDataService;

    public function __construct(ProfitAndLossReportService $service)
    {
        $this->service = $service;
        $this->reportDataService = app(ReportDataService::class);
    }

    public function index()
    {
        return view('report::finance.client-wise-revenue.dashboard');
    }

    public function dashboard()
    {
        return view('report::finance.dashboard');
    }

    public function clientWiseInvoiceDashboard(Request $request)
    {
        $data = $this->reportDataService->getDataForClientRevenueReportPage($request->all());

        return view('report::finance.client-wise-revenue.index', $data);
    }

    public function getReportData(Request $request)
    {
        $type = $request->type;
        $filters = $request->filters;

        return $this->reportDataService->getData($type, json_decode($filters, true));
    }
}
