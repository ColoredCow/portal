<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class ApplicantMeta extends Model
{
    protected $fillable = ['key', 'value', 'hr_applicant_id'];

    protected $table = 'hr_applicant_meta';

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'hr_applicant_id');
    }
}
