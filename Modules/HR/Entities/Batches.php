<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Batches extends Model
{
    protected $guarded = [];

    protected $table = 'batches';

    public function jobRequisition()
    {
        return $this->belongsTo(JobRequisition::class, 'batch_id');
    }

}
