<?php

namespace App\Models\HR;

use App\Models\HR\Application;
use App\Models\HR\ApplicationReview;
use App\Models\HR\Round;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApplicationRound extends Model
{
    protected $fillable = ['hr_application_id', 'hr_round_id', 'scheduled_date', 'scheduled_person_id', 'conducted_date', 'conducted_person_id', 'round_status', 'mail_sent', 'mail_subject', 'mail_body', 'mail_sender', 'mail_sent_at'];

    protected $table = 'hr_application_round';

    public $timestamps = false;

    public static function _create($attr)
    {
        return self::create($attr);
    }

    public function _update($attr)
    {
        $fillable = [
            'conducted_person_id' => Auth::id(),
            'conducted_date' => Carbon::now(),
        ];

        $application = $this->application;
        $applicant = $this->application->applicant;

        switch ($attr['action']) {
            case 'schedule-update':
                $fillable = [
                    'scheduled_date' => $attr['scheduled_date'],
                    'scheduled_person_id' => $attr['scheduled_person_id'],
                ];
                $attr['reviews'] = [];
                break;

            case 'confirm':
                $fillable['round_status'] = 'confirmed';
                $application->markInProgress();
                $nextApplicationRound = $application->job->rounds->where('id', $attr['next_round'])->first();
                $scheduledPersonId = $nextApplicationRound->pivot->hr_round_interviewer_id;
                $applicationRound = self::_create([
                    'hr_application_id' => $application->id,
                    'hr_round_id' => $attr['next_round'],
                    'scheduled_date' => Carbon::now()->addDay(),
                    'scheduled_person_id' => $scheduledPersonId ?? config('constants.hr.defaults.scheduled_person_id'),
                ]);
                break;

            case 'reject':
                $fillable['round_status'] = 'rejected';
                foreach ($applicant->applications as $applicantApplication) {
                    $applicantApplication->reject();
                }
                break;

            case 'refer':
                $fillable['round_status'] = 'rejected';
                $application->reject();
                $applicant->applications->where('id', $attr['refer_to'])->first()->markInProgress();
                break;
        }
        $this->update($fillable);
        $this->_updateOrCreateReviews($attr['reviews']);
    }

    protected function _updateOrCreateReviews($reviews = [])
    {
        foreach ($reviews as $review_key => $review_value) {
            $application_reviews = $this->applicationReviews()->updateOrCreate(
                [
                    'hr_application_round_id' => $this->id,
                ],
                [
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
