<?php

namespace Modules\CodeTrek\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CodeTrek\Database\factories\CodeTrekApplicantFactory;
use Modules\User\Entities\User;

class CodeTrekApplicant extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }

    public static function factory()
    {
        return new CodeTrekApplicantFactory();
    }

    public function getDaysInCodetrekAttribute()
    {
        $internshipStartDate = Carbon::parse($this->internship_start_date);
        if ($this->status == 'completed' && $internshipStartDate !== null) {
            return $internshipStartDate->diffInDays($this->start_date);
        }

        return now()->diffInDays($this->start_date);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
