<?php

namespace App\Models\HR;

use App\Models\HR\Applicant;
use App\Models\HR\Round;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ApplicantRound extends Model
{
    protected $fillable = ['hr_applicant_id', 'hr_round_id', 'scheduled_data', 'scheduled_person_id', 'conducted_date', 'conducted_person_id', 'round_status'];

    protected $table = 'hr_applicants_rounds';

    public $timestamps = false;

    public static function _create($attr)
    {
        return self::create($attr);
    }

    public function _update($attr)
    {
        return $this->update($attr);
    }

    public function _updateOrCreateReviews($reviews = [])
    {
        foreach ($reviews as $review_key => $review_value) {
            $applicant_reviews = $this->applicantReviews()->updateOrCreate(
                [
                    'hr_applicant_round_id' => $this->id,
                ],
                [
                    'review_key' => $review_key,
                    'review_value' => $review_value,
                ]
            );
        }
        return true;
    }

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
