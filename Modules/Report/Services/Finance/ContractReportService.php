<?php

namespace Modules\Report\Services\Finance;

use Modules\Client\Entities\Client;
use Modules\Project\Contracts\ProjectServiceContract;

class ContractReportService implements ProjectServiceContract
{
    public function getAllClientsData(array $data = [])
    {
        $statusFilter = [
            'status' => $data['status'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'sort' => $data['sort'] ?? 'name',
            'direction' => $data['direction'] ?? 'asc',
        ];

        $clientData = Client::with(['projects' => function ($query) use ($statusFilter) {
            if (! empty($statusFilter['status'])) {
                $query->where('status', $statusFilter['status']);
            }
            if (! empty($statusFilter['end_date'])) {
                $query->whereDate('end_date', $statusFilter['end_date']);
            }
            $query->orderBy('end_date', $statusFilter['direction']);
        }])
        ->with('clientContracts')
        ->with(['meta' => function ($query) {
            $query->select('client_id', 'key', 'value');
        }])
        ->where('is_billable', 1)
        ->get()
        ->sortBy(function ($client) use ($statusFilter) {
            if ($statusFilter['sort'] === 'name') {
                return strtolower($client->name);
            }
            $metaValue = optional($client->meta->where('key', 'contract_level')->first())->value;

            if ($metaValue == 'client' || $metaValue == 'project' || is_null($metaValue)) {
                $collection = $metaValue == 'client' ? $client->clientContracts : $client->projects;

                $filteredNullEndDate = $collection->filter(function ($item) {
                    return ! is_null($item->end_date);
                });

                return optional($filteredNullEndDate->first())->end_date;
            }
        }, SORT_REGULAR, $statusFilter['direction'] === 'desc')
        ->values();

        return $clientData;
    }
}
