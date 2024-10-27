<?php
namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class JobRequisition extends Model
{
    protected $guarded = [];

    protected $table = 'job_requisition';

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function hrJobDomain()
    {
        return $this->belongsTo(HrJobDomain::class, 'domain_id');
    }

    public function batches()
    {
        return $this->belongsTo(HRRequisitionHiredBatch::class, 'hired_batch_id');
    }

    public function hRRequisitionHiredBatchMembers()
    {
        return $this->hasmany(HRRequisitionHiredBatchMembers::class, 'batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
