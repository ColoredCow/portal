<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Modules\Report\Services\Finance\ContractReportService;
use App\Models\Setting;

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
        $alertDiff =  Setting::where('setting_key', 'contract_endDate_threshold')->value('setting_value');

        return view('report::finance.project-contract.index', [
            'clientsData' => $clientsData,
            'alertDiff' => $alertDiff,
        ]);
    }
}
