<?php
namespace Modules\Report\Http\Controllers;

use App\Models\Setting;
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
        $clientsData = $this->service->getAllClientsData(request()->all());
        $contractEndDateThreshold = Setting::where('setting_key', 'contract_end_date_threshold')->value('setting_value');

        return view('report::finance.project-contract.index', [
            'clientsData' => $clientsData,
            'contractEndDateThreshold' => $contractEndDateThreshold,
        ]);
    }
}
