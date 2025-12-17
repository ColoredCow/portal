<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class IndividualAssessment extends Model
{
    public $timestamps = true;
    protected $table = 'individual_assessments';
    protected $guarded = [];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
