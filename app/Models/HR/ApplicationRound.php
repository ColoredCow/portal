<?php

namespace App\Models\HR;

use App\Helpers\FileHelper;
use App\Models\HR\Application;
use App\Models\HR\Evaluation\ApplicationEvaluation;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApplicationRound extends Model
{
    protected $guarded = [];

    protected $table = 'hr_application_round';

    public $timestamps = false;

    public function updateOrCreateEvaluation($evaluations = [])
    {
        foreach ($evaluations as $evaluation_id => $evaluation) {
            if (array_key_exists('option_id', $evaluation)) {
                $this->evaluations()->updateOrCreate(
                    [
                        'application_round_id' => $this->id,
                        'evaluation_id' => $evaluation['evaluation_id'],
                        'application_id' => $this->hr_application_id,
                    ],
                    [
                        'option_id' => $evaluation['option_id'],
                        'comment' => $evaluation['comment'],
                    ]
                );
            }
        }

        return true;
    }

    protected function _updateOrCreateReviews($reviews = [])
    {
        foreach ($reviews as $review_key => $review_value) {
            $application_reviews = $this->applicationRoundReviews()->updateOrCreate(
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

    public function applicationRoundReviews()
    {
        return $this->hasMany(ApplicationRoundReview::class, 'hr_application_round_id');
    }

    public function evaluations()
    {
        return $this->hasMany(ApplicationEvaluation::class, 'application_round_id');
    }

    public function mailSender()
    {
        return $this->belongsTo(User::class, 'mail_sender');
    }

    /**
     * Get communication mail for this application round.
     *
     * @return array
     */
    public function getCommunicationMailAttribute()
    {
        return [
            'modal-id' => 'round_mail_' . $this->id,
            'mail-to' => $this->application->applicant->email,
            'mail-subject' => $this->mail_subject,
            'mail-body' => $this->mail_body,
            'mail-sender' => $this->mailSender->name,
            'mail-date' => $this->mail_sent_at,
        ];
    }

    public function getNoShowAttribute()
    {
        if ($this->round_status) {
            return null;
        }

        $scheduledDate = Carbon::parse($this->scheduled_date);
        if ($scheduledDate < Carbon::now()->subHours(config('constants.hr.no-show-hours-limit'))) {
            return true;
        }

        return null;
    }

    public static function scheduledForToday()
    {
        $applicationRounds = self::with(['application', 'application.job'])
            ->whereHas('application', function ($query) {
                $query->whereIn('status', [
                    config('constants.hr.status.new.label'),
                    config('constants.hr.status.in-progress.label'),
                    config('constants.hr.status.no-show.label'),
                ]);
            })
            ->whereNull('round_status')
            ->whereDate('scheduled_date', '=', Carbon::today()->toDateString())
            ->orderBy('scheduled_date')
            ->get();

        // Using Laravel's collection method groupBy to group scheduled application rounds based on the scheduled person
        return $applicationRounds->groupBy('scheduled_person_id');
    }

    public function isRejected()
    {
        return $this->round_status == config('constants.hr.status.rejected.label');
    }

    public function isConfirmed()
    {
        return $this->round_status = config('constants.hr.status.confirmed.label');
    }

    public function isOnboarded()
    {
        return $this->status == config('constants.hr.status.onboarded.label');
    }

    /**
     * Defines whether to show actions dropdown for an application round. An action can only be taken
     * if the application round status is null or rejected. Also, returns true if the application
     * round is confirmed but the application is sent/waiting for approval.
     *
     * @return boolean
     */
    public function getShowActionsAttribute()
    {
        return is_null($this->round_status) || $this->isRejected() || (!$this->isOnboarded());
    }

    public function updateSchedule($attr, Application $application)
    {
        // If the application status is no-show or no-show-reminded, and the new schedule date is greater
        // than the current time, we change the application status to in-progress.
        if ($application->isNoShow() && Carbon::parse($attr['scheduled_date'])->gt(Carbon::now())) {
            $application->markInProgress();
        }
        $this->update([
            'scheduled_date' => $attr['scheduled_date'],
            'scheduled_person_id' => $attr['scheduled_person_id'],
        ]);
    }

    public function comfirm()
    {
        $this->update(['round_status' => 'confirmed']);
    }

    public function reject()
    {
        $this->update(['round_status' => 'rejected']);
    }

    public function approve()
    {
        $this->update(['round_status' => 'approved']);
    }
}
