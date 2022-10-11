<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class HRRequisitionHiredBatch extends Model
{
    protected $guarded = [];

    protected $table = 'hr_requisiton_hired_batches';

    public function jobRequisition()
    {
        return $this->belongsTo(JobRequisition::class, 'batch_id');
    }
}
