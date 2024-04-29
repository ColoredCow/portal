<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Modules\Report\Services\Finance\ContractReportService;

class ContractReportController extends Controller
{
    use AuthorizesRequests;
    protected $service;

    public function __construct(ContractReportService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $clientsData = $this->service->getAllClientsData();

        return view('report::finance.project-contract.index', [
            'clientsData' => $clientsData,
        ]);
    }
}
