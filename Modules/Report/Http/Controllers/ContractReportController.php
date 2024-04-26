<?php

namespace Modules\Report\Http\Controllers;

use App\Models\Client;
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
    /**
     * Show the specified resource.
     *
     * @param client $client
     */
    public function getAllProject(client $client)
    {
        $clientData = $this->service->getAllProjectsData($client->all());

        return view('report::finance.project-contract.index', [
            'project' => $client,
            'ClientDetail' => $clientData,
        ]);
    }
}
