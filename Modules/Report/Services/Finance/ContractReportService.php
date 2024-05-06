<?php

namespace Modules\Report\Services\Finance;

use Modules\Client\Entities\Client;
use Modules\Project\Contracts\ProjectServiceContract;

class ContractReportService implements ProjectServiceContract
{
    public function getAllClientsData()
    {
        $clientData = Client::query()
            ->with(['projects' => function ($query) {
                $query->where('status', 'active');
            }])
            ->whereHas('projects')
            ->orderBy('name')
            ->get();

        return $clientData;
    }
}
