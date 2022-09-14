<?php

namespace Modules\HR\Services;

use Modules\HR\Entities\JobRequisition;

class RequisitionService
{
    public function index()
    {
        return JobRequisition::with('hrJobDomain', 'job')->where('status', 'pending')->get();
    }

    public function showCompletedRequisition()
    {
        return JobRequisition::with('hrJobDomain', 'job')->where('status', 'completed')->get();
    }
}
