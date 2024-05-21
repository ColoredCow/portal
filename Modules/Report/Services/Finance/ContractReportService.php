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
                $query->select('client_id', 'key', 'value');
            }])
            ->where('is_billable', 1)
            ->whereHas('projects', function ($query) {
                $query->where('status', 'active');
            })
            ->get()
            ->sortBy(function ($client) {
                $metaValue = optional($client->meta->where('key', 'contract_level')->first())->value;

                if ($metaValue == 'client' || $metaValue == 'project' || is_null($metaValue)) {
                    $collection = $metaValue == 'client' ? $client->clientContracts : $client->projects;

                    $filteredNullEndDate = $collection->filter(function ($item) {
                        return !is_null($item->end_date);
                    });

                    return optional($filteredNullEndDate->sortBy('end_date')->first())->end_date;
                }

                return;
            })
            ->values();

        return $clientData;
    }
}
