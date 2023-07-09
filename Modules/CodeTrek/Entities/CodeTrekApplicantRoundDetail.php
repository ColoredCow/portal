<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CodeTrek\Database\factories\CodeTrekApplicantRoundDetailsFactory;

class CodeTrekApplicantRoundDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'codetrek_applicant_round_details';

    public static function newFactory()
    {
        return new CodeTrekApplicantRoundDetailsFactory();
    }

    public function applicant()
    {
        return $this->belongsTo(CodeTrekApplicant::class);
    }
}
