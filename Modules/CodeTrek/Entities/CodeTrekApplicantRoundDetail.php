<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeTrekApplicantRoundDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function applicant()
    {
        return $this->belongsTo(CodeTrekApplicant::class);
    }
}
