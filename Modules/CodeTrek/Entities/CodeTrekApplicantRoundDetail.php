<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CodeTrek\Database\factories\CodeTrekApplicantRoundDetailsFactory;

class CodeTrekApplicantRoundDetail extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'codetrek_applicant_round_details';

    public static function factory()
    {
        return new CodeTrekApplicantRoundDetailsFactory();
    }

    public function applicant()
    {
        return $this->belongsTo(CodeTrekApplicant::class);
    }
}
