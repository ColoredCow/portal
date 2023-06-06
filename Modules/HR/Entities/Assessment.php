<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = ['reviewee_id'];
    protected $table = 'assessments';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
