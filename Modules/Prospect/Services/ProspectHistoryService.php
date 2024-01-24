<?php

namespace Modules\Prospect\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Prospect\Contracts\ProspectHistoryServiceContract;
use Modules\Prospect\Contracts\ProspectServiceContract;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectHistory;

class ProspectHistoryService implements ProspectHistoryServiceContract
{
    protected $prospectService;

    public function __construct()
    {
        $this->prospectService = app(ProspectServiceContract::class);
    }

    public function store($data, $prospectId)
    {
        $prospect = Prospect::find($prospectId);
        $prospectHistory = new ProspectHistory($data);
        $prospectHistory->created_by = Auth::id();
        $prospect->histories()->save($prospectHistory);
        if (isset($data['prospect_documents']) && $data['prospect_documents']) {
            $this->prospectService->uploadDocuments($data['prospect_documents'], $prospect, $prospectHistory);
        }
    }
}
