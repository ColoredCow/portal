<?php

namespace Modules\HR\Services;

use Modules\HR\Entities\JobRequisition;

class RequisitionService
{
    public function index()
    {
        return JobRequisition::with('hrJobDomain', 'job', 'batches')->where('status', 'pending')->get();
    }

    public function showCompletedRequisition()
    {
        return JobRequisition::with('hrJobDomain', 'job', 'batches')->where('status', 'completed')->get();
    }
}