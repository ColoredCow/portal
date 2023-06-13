<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Report\Services\Finance\MonthlSalesRegisterService;

class MonthlySalesRegisterController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(MonthlSalesRegisterService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        if (! $filters) {
            return redirect(route('reports.finance.monthly-sales-register.index', $this->service->defaultMonthlySalesRegisterReportFilters()));
        }

        return view('report::finance.monthly-sales-register.index', $this->service->index($filters));
    }

    public function exportReport(Request $request)
    {
        $filters = $request->all();

        return $this->service->exportReport($filters);
    }
}
