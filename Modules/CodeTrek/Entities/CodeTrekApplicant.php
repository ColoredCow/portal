<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Operations\Entities\OfficeLocation;
use Modules\CodeTrek\Database\Factories\CodeTrekApplicantsFactory;
use Modules\User\Entities\User;

class CodeTrekApplicant extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }

    public static function factory()
    {
        return new CodeTrekApplicantsFactory();
    }


    public function center()
    {
        return $this->belongsTo(OfficeLocation::class, 'center_id');
    }
}
