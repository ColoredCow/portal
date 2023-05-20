<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CodeTrek\Database\Factories\CodeTrekApplicantFactory;
use Modules\Operations\Entities\OfficeLocation;

class CodeTrekApplicant extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    protected $table = 'code_trek_applicants';

    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class, 'Applicant_id');
    }

    public static function newFactory()
    {
        return new CodeTrekApplicantFactory();
    }

    public function center()
    {
        return $this->belongsTo(OfficeLocation::class, 'center_id');
    }
}
