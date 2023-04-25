<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeTrekApplicantRoundDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'codetrek_applicant_round_details';

    public function applicant()
    {
        $data= CodeTrekApplicant::orderBy('name')->get();
        dd($data);
        return $this->belongsTo(CodeTrekApplicant::class);
    }
}
