<?php

namespace Modules\CodeTrek\Entities;

use Modules\CodeTrek\Database\Factories\CodetrekApplicantRoundDetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return new CodetrekApplicantRoundDetailFactory();
    }
}
