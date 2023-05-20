<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Operations\Entities\OfficeLocation;

class CodeTrekApplicant extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }

    public function center()
    {
        return $this->belongsTo(OfficeLocation::class, 'center_id');
    }
}
