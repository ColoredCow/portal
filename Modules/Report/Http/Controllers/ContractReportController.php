<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Project\Entities\ProjectContract;
use Modules\Report\Services\Finance\ContractReportService;
use App\Http\Requests\ClientRequest;
use App\Models\Client;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Modules\Client\Entities\Client;
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
         // Fetch data from the service
         $clientData = $this->service->getAllProjectsData($client->all());        
        
         return view('report::finance.project-contract.index', [
             'project' => $client,
             'ClientDetail' => $clientData,
         ]);
     }
    }