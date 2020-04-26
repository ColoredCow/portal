<?php

namespace Modules\Prospect\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectHistory;
use Modules\Prospect\Contracts\ProspectHistoryServiceContract;

class ProspectHistoryService implements ProspectHistoryServiceContract
{
    public function store($data, $prospectId)
    {
        $prospect = Prospect::find($prospectId);
        $prospectHistory = new ProspectHistory($data);
        $prospectHistory->created_by = Auth::id();
        return $prospect->histories()->save($prospectHistory);
    }
}
