<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class JobRequisition extends Model
{
    protected $guarded = [];

    protected $table = 'job_Requisition';

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
        return $this->belongsTo(Batches::class, 'batch_table_id');
    }
}
