<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeTrekApplicant extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }
}
