<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeTrekApplicant extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $fillable = [

        'first_name',
        'last_name',
        'email',
        'github_user_name',
        'phone',
        'course',
        'start_date',
        'graduation_year',
        'university',
    ];

    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }
}
