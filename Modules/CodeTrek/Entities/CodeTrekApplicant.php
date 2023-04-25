<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeTrekApplicant extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function roundDetails()
    {
        $data = CodeTrekApplicant::orderBy('name')->get();
        dd($data);
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }
}
