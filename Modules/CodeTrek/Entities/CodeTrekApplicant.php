<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Operations\Entities\OfficeLocation;
use Modules\User\Entities\User;
use App\Models\Session;

class CodeTrekApplicant extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }

    public function center()
    {
        return $this->belongsTo(OfficeLocation::class, 'center_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function sessions()
    {
        return $this->morphToMany(Session::class, 'model', 'model_has_sessions');
    }
}
