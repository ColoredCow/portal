<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CodeTrek\Database\factories\CodetrekApplicantRoundFactory;

class CodeTrekApplicantRoundDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'codetrek_applicant_round_details';

    public function applicant()
    {
        return $this->belongsTo(CodeTrekApplicant::class);
    }

    public static function newFactory()
    {
        return new CodetrekApplicantRoundFactory();
    }
}
