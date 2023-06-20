<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    public $timestamps = true;
    protected $table = 'assessments';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'reviewee_id');
    }

    public function individualAssessments()
    {
        return $this->hasMany(IndividualAssessment::class);
    }
}
