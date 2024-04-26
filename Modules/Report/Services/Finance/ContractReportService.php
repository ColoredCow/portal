<?php

namespace Modules\Report\Services\Finance;

use Modules\Client\Entities\Client;
use Modules\Project\Contracts\ProjectServiceContract;
class ContractReportService implements ProjectServiceContract
{
    public function getAllProjectsData()
    {
        $ClientData = Client::query()
        ->with('projects')
        ->whereHas('projects')
        ->orderBy('name')
        ->paginate(config('constants.pagination_size'));
  
         return $ClientData;
    }    
}