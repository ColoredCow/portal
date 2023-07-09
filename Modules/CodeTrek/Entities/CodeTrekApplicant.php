<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Operations\Entities\OfficeLocation;
use Modules\CodeTrek\Database\Factories\CodeTrekApplicantFactory;
use Modules\User\Entities\User;

class CodeTrekApplicant extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }

    public static function newFactory()
    {
        return new CodeTrekApplicantFactory();
    }

    public function center()
    {
        return $this->belongsTo(OfficeLocation::class, 'center_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
