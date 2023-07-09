<?php

namespace Modules\CodeTrek\Entities;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Operations\Entities\OfficeLocation;
use Modules\CodeTrek\Database\Factories\CodeTrekApplicantsFactory;
use Modules\User\Entities\User;

class CodeTrekApplicant extends Model
{
    use SoftDeletes,Notifiable, HasFactory;
    protected $guarded = [];

    protected $table = 'code_trek_applicants';
    
    /**
     * Custom create method that creates an applicant and fires specific events.
     *
     * @param  array $attr  fillables to be stored
     */
    public function roundDetails()
    {
        return $this->hasMany(CodeTrekApplicantRoundDetail::class);
    }

    public static function newFactory()
    {
        return new CodeTrekApplicantsFactory();
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
