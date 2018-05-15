<?php

namespace App\Models\HR;

use App\Models\HR\Applicant;
use App\Models\HR\ApplicantReview;
use App\Models\HR\Round;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApplicantRound extends Model
{
    protected $fillable = ['hr_applicant_id', 'hr_round_id', 'scheduled_data', 'scheduled_person_id', 'conducted_date', 'conducted_person_id', 'round_status', 'mail_sent', 'mail_subject', 'mail_body', 'mail_sender', 'mail_sent_at'];

    protected $table = 'hr_applicants_rounds';

    public $timestamps = false;

    public static function _create($attr)
    {
        return self::create($attr);
    }

    public function _update($attr, $type = 'new', $reviews = [], $nextRound = 0)
    {
        $this->update($attr);
        $this->_updateOrCreateReviews($reviews);

        if ($type == 'update') {
            return;
        }

        $applicant = $this->applicant;
        if ($attr['round_status']) {
            $status = config('constants.hr.status');
            $rejectedStatus = $status['rejected']['label'];
            $inProgressStatus = $status['in-progress']['label'];
            $applicantStatus = ($attr['round_status'] === $rejectedStatus) ? $rejectedStatus : $inProgressStatus;
            $applicant->update([ 'status' => $applicantStatus ]);
        }

        if ($nextRound) {
            $scheduled_person = User::findByEmail($applicant->applications->first()->job->posted_by);
            $applicantRound = self::_create([
                'hr_applicant_id' => $applicant->id,
                'hr_round_id' => $nextRound,
                'scheduled_date' => Carbon::now()->addDay(),
                'scheduled_person_id' => $scheduled_person ? $scheduled_person->id : config('constants.hr.defaults.scheduled_person_id'),
            ]);
        }
    }

    protected function _updateOrCreateReviews($reviews = [])
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

    public function mailSender()
    {
        return $this->belongsTo(User::class, 'mail_sender');
    }
}
