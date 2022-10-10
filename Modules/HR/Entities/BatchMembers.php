<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class BatchMembers extends Model
{
    protected $guarded = [];

    protected $table = 'batch_members';

    public function jobRequisition()
    {
        return $this->belongsTo(JobRequisition::class, 'batch_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
