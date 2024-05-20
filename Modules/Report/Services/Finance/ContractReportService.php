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
                $query->where('status', 'active')->orderBy('end_date', 'asc');
            }])
            ->with('clientContracts')
            ->with(['meta' => function ($query) {
                $query->select('client_id', 'value');
            }])
            ->whereHas('projects', function ($query) {
                $query->where('status', 'active');
            })
            ->get()
            ->sortBy(function ($client) {
                $metaValue = optional($client->meta->first())->value;

                if ($metaValue == 'client') {
                    return optional($client->clientContracts->sortBy('end_date')->first())->end_date;
                } elseif ($metaValue == 'project' || is_null($metaValue)) {
                    return optional($client->projects->sortBy('end_date')->first())->end_date;
                } else {
                    return null;
                }
            })
            ->values();

        return $clientData;
    }
}
