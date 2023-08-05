<?php

namespace Modules\HR\Services;

class RequisitionService
{
    public function index()
    {
        return JobRequisition::with('hrJobDomain', 'job', 'batches')->where('status', 'pending')->get();
    }

    public function showCompletedRequisition()
    {
        return JobRequisition::with('hrJobDomain', 'job')->where('status', 'completed')->get();
    }
}
