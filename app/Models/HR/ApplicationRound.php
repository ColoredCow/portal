<?php

namespace App\Models\HR;

use App\Models\HR\Applicant;
use App\Models\HR\ApplicationReview;
use App\Models\HR\Round;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApplicationRound extends Model
{
    protected $fillable = ['hr_applicant_id', 'hr_application_id', 'hr_round_id', 'scheduled_data', 'scheduled_person_id', 'conducted_date', 'conducted_person_id', 'round_status', 'mail_sent', 'mail_subject', 'mail_body', 'mail_sender', 'mail_sent_at'];

    protected $table = 'hr_application_round';

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

        $application = $this->application;
        $applicant = $this->application->applicant;
        if ($attr['round_status']) {
            $status = config('constants.hr.status');
            $rejectedStatus = $status['rejected']['label'];
            $inProgressStatus = $status['in-progress']['label'];
            $applicationStatus = ($attr['round_status'] === $rejectedStatus) ? $rejectedStatus : $inProgressStatus;
            $application->update([ 'status' => $applicationStatus ]);
        }

        if ($nextRound) {
            $nextJobRound = $application->job->rounds->where('id', $nextRound)->first();
            $scheduledPersonId = $nextJobRound->pivot->hr_round_interviewer_id;
            $applicationRound = self::_create([
                'hr_applicant_id' => $applicant->id,
                'hr_application_id' => $application->id,
                'hr_round_id' => $nextRound,
                'scheduled_date' => Carbon::now()->addDay(),
                'scheduled_person_id' => $scheduledPersonId ?? config('constants.hr.defaults.scheduled_person_id'),
            ]);
        }
    }

    protected function _updateOrCreateReviews($reviews = [])
    {
        foreach ($reviews as $review_key => $review_value) {
            $application_reviews = $this->applicationReviews()->updateOrCreate(
                [
                    'hr_application_round_id' => $this->id,
                ],
                [
                    'hr_applicant_round_id' => $this->id,
                    'review_key' => $review_key,
                    'review_value' => $review_value,
                ]
            );
        }
        return true;
    }

    public function application()
    {
    	return $this->belongsTo(Application::class, 'hr_application_id');
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

    public function applicationReviews()
    {
        return $this->hasMany(ApplicationReview::class, 'hr_application_round_id');
    }

    public function mailSender()
    {
        return $this->belongsTo(User::class, 'mail_sender');
    }
}
