<?php

namespace App\Models\HR;

use App\Models\HR\Applicant;
use App\Models\HR\Round;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ApplicantRound extends Model
{
    protected $fillable = ['hr_applicant_id', 'hr_round_id', 'scheduled_person_id', 'conducted_person_id'];

    protected $table = 'hr_applicants_rounds';

    public $timestamps = false;

    public function applicant()
    {
    	return $this->belongsTo(Applicant::class, 'hr_applicant_id');
    }

    public function round()
    {
    	return $this->belongsTo(Round::class, 'hr_round_id');
    }

    public function scheduledPerson()
    {
    	return $this->belongsTo(User::class, 'scheduled_person_id');
    }

    public function conductedPerson()
    {
    	return $this->belongsTo(User::class, 'conducted_person_id');
    }

    public function applicantReviews()
    {
        return $this->hasMany(ApplicantReview::class, 'hr_applicant_round_id');
    }
}
