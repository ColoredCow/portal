<?php

namespace App\Models\HR;

use App\Models\HR\Application;
use App\Models\HR\ApplicationRoundEvaluation;
use App\Models\HR\ApplicationRoundReview;
use App\Models\HR\Round;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApplicationRound extends Model
{
    protected $guarded = [];

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
                $scheduledPersonId = $nextApplicationRound->pivot->hr_round_interviewer_id ?? config('constants.hr.defaults.scheduled_person_id');
                $applicationRound = self::_create([
                    'hr_application_id' => $application->id,
                    'hr_round_id' => $attr['next_round'],
                    'scheduled_date' => $attr['next_scheduled_start'],
                    'scheduled_end' => isset($attr['next_scheduled_end']) ? $attr['next_scheduled_end'] : null,
                    'scheduled_person_id' => $attr['next_scheduled_person_id'],
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

    public function updateOrCreateEvaluation($evaluations = [])
    {
        foreach ($evaluations as $evaluation_id => $evaluation) {
            if (array_key_exists('option_id', $evaluation)) {
                $this->evaluations()->updateOrCreate(
                    [
                        'application_round_id' => $this->id,
                        'evaluation_id' => $evaluation['evaluation_id'],
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
        return $this->hasMany(ApplicationRoundEvaluation::class, 'application_round_id');
    }

    public function mailSender()
    {
        return $this->belongsTo(User::class, 'mail_sender');
    }

    /**
     * Get communication mail for this application round
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
                $query->whereIn('status', ['new', 'in-progress', 'no-show']);
            })
            ->whereDate('scheduled_date', '=', Carbon::today()->toDateString())
            ->orderBy('scheduled_date')
            ->get();

        // Using Laravel's collection method groupBy to group scheduled application rounds based on the scheduled person
        return $applicationRounds->groupBy('scheduled_person_id');
    }
}
