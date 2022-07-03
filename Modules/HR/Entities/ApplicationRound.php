<?php

namespace Modules\HR\Entities;

use App\Helpers\FileHelper;
use App\Traits\HasTags;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Communication\Traits\HasCalendarMeetings;
use Modules\HR\Emails\Recruitment\SendForApproval;
use Modules\HR\Emails\Recruitment\SendOfferLetter;
use Modules\HR\Entities\Evaluation\ApplicationEvaluation;
use Modules\User\Entities\User;
use App\Models\Setting;
use Modules\HR\Emails\Recruitment\Applicant\OnHold;
use Modules\HR\Database\Factories\HrApplicationRoundFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationRound extends Model
{
    use HasTags, HasCalendarMeetings, HasFactory;

    protected $guarded = [];

    protected $table = 'hr_application_round';

    public $timestamps = false;

    protected $dates = [
        'scheduled_date',
        'conducted_date',
    ];

    public static function newFactory()
    {
        return new HrApplicationRoundFactory();
    }

    public function _update($attr)
    {
        // TODO: the fillable definition below need to be put somewhere else.
        // When just updating an application round (maybe updating comment), the below details are getting overriden.
        $fillable = [
            'conducted_person_id' => auth()->id(),
            'conducted_date' => now(),
        ];

        $application = $this->application;
        $applicant = $this->application->applicant;
        $nextRound = Round::find($attr['next_round']);

        switch ($attr['action']) {
            case 'schedule-update':

                // If the application status is no-show or no-show-reminded, and the new schedule date is greater
                // than the current time, we change the application status to in-progress.
                if ($application->isNoShow() && Carbon::parse($attr['scheduled_date'])->gt(now())) {
                    $application->markInProgress();
                }
                $fillable = [
                    'scheduled_date' => $attr['scheduled_date'],
                    'scheduled_person_id' => $attr['scheduled_person_id'],
                ];
                $attr['reviews'] = [];
                break;

            case 'confirm':
                $application->untag('new-application');
                $application->tag('in-progress');
                //move application to Trial Round
                if (($nextRound->isTrialRound())) {
                    $fillable['round_status'] = 'confirmed';
                    $this->update($fillable);
                    $application->markInProgress();
                    $nextApplicationRound = $application->job->rounds->where('id', $attr['next_round'])->first();
                    $scheduledPersonId = $nextApplicationRound->pivot->hr_round_interviewer_id ?? config('constants.hr.defaults.scheduled_person_id');
                    $applicationRound = self::create([
                    'hr_application_id' => $application->id,
                    'hr_round_id' => $nextRound->id,
                    'trial_round_id' => Round::where('name', 'Preparatory-1')->first()->id,
                    'scheduled_date' => $attr['next_scheduled_start'] ?? null,
                    'scheduled_end' => isset($attr['next_scheduled_end']) ? $attr['next_scheduled_end'] : null,
                    'scheduled_person_id' => $attr['next_scheduled_person_id'] ?? null,
                    ]);
                }
                //if application are requested to move to preparatory or warmup round then they are automatically moved to Trial Round
                //and trial_round_id column is set to the id of preparatory rounds that is requested
                elseif ($nextRound->inPreparatoryRounds()) {
                    $fillable['round_status'] = 'confirmed';
                    $this->update($fillable);
                    $application->markInProgress();
                    $nextApplicationRound = $application->job->rounds->where('id', Round::where('name', 'Trial Program')->first()->id)->first();
                    $scheduledPersonId = $nextApplicationRound->pivot->hr_round_interviewer_id ?? config('constants.hr.defaults.scheduled_person_id');
                    $applicationRound = self::create([
                    'hr_application_id' => $application->id,
                    'hr_round_id' => Round::where('name', 'Trial Program')->first()->id,
                    'trial_round_id' => $nextRound->id,
                    'scheduled_date' => $attr['next_scheduled_start'] ?? null,
                    'scheduled_end' => isset($attr['next_scheduled_end']) ? $attr['next_scheduled_end'] : null,
                    'scheduled_person_id' => $attr['next_scheduled_person_id'] ?? null,
                    ]);
                }
                //For Pre-trial Rounds
                else {
                    $fillable['round_status'] = 'confirmed';
                    $this->update($fillable);
                    $application->markInProgress();
                    $nextApplicationRound = $application->job->rounds->where('id', $attr['next_round'])->first();
                    $scheduledPersonId = $nextApplicationRound->pivot->hr_round_interviewer_id ?? config('constants.hr.defaults.scheduled_person_id');
                    $applicationRound = self::create([
                    'hr_application_id' => $application->id,
                    'hr_round_id' => $nextRound->id,
                    'scheduled_date' => $attr['next_scheduled_start'] ?? null,
                    'scheduled_end' => isset($attr['next_scheduled_end']) ? $attr['next_scheduled_end'] : null,
                    'scheduled_person_id' => $attr['next_scheduled_person_id'] ?? null,
                    ]);
                }
                break;

            case 'reject':
                $application->untag('new-application');
                $fillable['round_status'] = 'rejected';
                if (! empty($attr['follow_up_comment_for_reject'])) {
                    $this->followUps()->create([
                        'comments' => $attr['follow_up_comment_for_reject'],
                        'conducted_by' => auth()->id(),
                    ]);
                    $this->untag('need-follow-up');
                }
                foreach ($applicant->applications as $applicantApplication) {
                    $applicantApplication->reject();
                }
                foreach ($attr['reject_reason'] as $rejectReason) {
                    if (isset($rejectReason['title'])) {
                        HRRejectionReason::create([
                            'hr_application_round_id' => $this->id,
                            'reason_title' => $rejectReason['title'],
                            'reason_comment' => $rejectReason['comment'] ?? null,
                        ]);
                    }
                }
                break;

            case 'refer':
                $fillable['round_status'] = 'rejected';
                $application->reject();
                $applicant->applications->where('id', $attr['refer_to'])->first()->markInProgress();
                break;

            case 'on-hold':
                $application->untag('new-application');
                $application->untag('in-progress');
                $fillable['round_status'] = 'on-hold';
                $application->onHold();

                ApplicationMeta::create([
                'hr_application_id' => $application->id,
                'key' => 'on-hold',
                'value' => json_encode([
                'on-hold_by' => $fillable['conducted_person_id']])
                ]);

                $applicant = $application->applicant;

                $subject = Setting::where('module', 'hr')->where('setting_key', 'application_on_hold_subject')->first();
                $body = Setting::where('module', 'hr')->where('setting_key', 'application_on_hold_body')->first();
                $job_title = Job::find($application->hr_job_id)->title;
                $body->setting_value = str_replace(config('constants.hr.template-variables.applicant-name'), $applicant->name, $body->setting_value);
                $body->setting_value = str_replace(config('constants.hr.template-variables.job-title'), $job_title, $body->setting_value);

                Mail::to($applicant->email, $applicant->name)
                    ->send(new OnHold($subject->setting_value, $body->setting_value));

                return redirect()->route('applications.job.index');
                break;

            case 'send-for-approval':
                $application->untag('new-application');
                $application->untag('in-progress');
                $fillable['round_status'] = 'confirmed';
                $application->sendForApproval($attr['send_for_approval_person']);

                ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'sent-for-approval',
                    'value' => json_encode([
                        'conducted_person_id' => $fillable['conducted_person_id'],
                        'supervisor_id' => $attr['send_for_approval_person'],
                    ]),
                ]);

                $supervisor = User::find($attr['send_for_approval_person']);
                Mail::send(new SendForApproval($supervisor, $application));
                break;

            case 'approve':
                $application->untag('new-application');
                $application->untag('in-progress');
                $fillable['round_status'] = 'approved';
                $application->approve();

                ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'approved',
                    'value' => json_encode([
                        'approved_by' => $fillable['conducted_person_id'],
                    ]),
                ]);

                $subject = $attr['subject'];
                $body = $attr['body'];

                if (! $application->offer_letter) {
                    $application->offer_letter = FileHelper::generateOfferLetter($application);
                }
                Mail::send(new SendOfferLetter($application, $subject, $body));
                break;

            case 'onboard':
                $application->untag('new-application');
                $application->untag('in-progress');
                $fillable['round_status'] = 'confirmed';
                $application->onboarded();

                ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'onboarded',
                    'value' => json_encode([
                        'onboarded_by' => $fillable['conducted_person_id'],
                    ]),
                ]);

                // The below env call needs to be changed to config after the default
                // credentials bug in the Google API services is resolved.
                $email = $attr['onboard_email'] . '@' . env('GOOGLE_CLIENT_HD');
                $applicant->onboard($email, $attr['onboard_password'], [
                    'designation' => $attr['designation'],
                ]);

                User::create([
                    'email' => $email,
                    'name' => $applicant->name,
                    'password' => Hash::make($attr['onboard_password']),
                    'provider' => 'google',
                    'provider_id' => '',
                ]);
                break;

            case 'update':
                // this is a workaround to nullify the fillable array so that in case of
                // regular update, nothing gets changed in the application round except the reviews.
                $fillable = [];
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
                        'application_id' => $this->hr_application_id,
                    ],
                    [
                        'option_id' => $evaluation['option_id'],
                        'comment' => $evaluation['comment'] ?? null,
                    ]
                );
            }
        }

        return true;
    }

    public function updateOrCreateEvaluationSegment($segments = [])
    {
        foreach ($segments as $segmentId => $segment) {
            $this->segments()->updateOrCreate(
                [
                    'application_round_id' => $this->id,
                    'application_id' => $this->hr_application_id,
                    'evaluation_segment_id' => $segment['evaluation_segment_id'],
                ],
                [
                    'comments' => $segment['comments'],
                ]
            );
        }

        return true;
    }

    protected function _updateOrCreateReviews($reviews = [])
    {
        foreach ($reviews[$this->id] ?? [] as $review_key => $review_value) {
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

    public function trialRound()
    {
        return $this->belongsTo(Round::class, 'trial_round_id');
    }

    public function round()
    {
        return $this->belongsTo(Round::class, 'hr_round_id');
    }

    public function scheduledPerson()
    {
        return $this->belongsTo(User::class, 'scheduled_person_id')->withTrashed();
    }

    public function conductedPerson()
    {
        return $this->belongsTo(User::class, 'conducted_person_id')->withTrashed();
    }

    public function applicationRoundReviews()
    {
        return $this->hasMany(ApplicationRoundReview::class, 'hr_application_round_id');
    }

    public function evaluations()
    {
        return $this->hasMany(ApplicationEvaluation::class, 'application_round_id');
    }

    public function segments()
    {
        return $this->hasMany(ApplicationEvaluationSegment::class);
    }

    public function mailSender()
    {
        return $this->belongsTo(User::class, 'mail_sender');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'hr_application_round_id');
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
            'mail-sender' => $this->mailSender ? $this->mailSender->name : 'NA',
            'mail-date' => $this->mail_sent_at,
        ];
    }

    public function getNoShowAttribute()
    {
        if ($this->round_status) {
            return;
        }

        $scheduledDate = Carbon::parse($this->scheduled_date);
        if ($scheduledDate < Carbon::now()->subHours(config('constants.hr.no-show-hours-limit'))) {
            return true;
        }
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
            ->whereDate('scheduled_date', '=', today()->toDateString())
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
     * @return bool
     */
    public function getShowActionsAttribute()
    {
        if ($this->isRejected()) {
            return true;
        }

        if ($this->conducted_date) {
            return false;
        }

        return is_null($this->round_status) || (! $this->isOnboarded());
    }

    public function getPreviousApplicationRound()
    {
        return self::with('round')->where('hr_application_id', $this->hr_application_id)
            ->where('round_status', 'confirmed')
            ->whereNotNull('conducted_date')
            ->where('id', '<', $this->id)
            ->orderByDesc('id')
            ->first();
    }

    public function updateIsLatestColumn()
    {
        if ($this->round->isTrialRound()) {
            self::where('hr_application_id', $this->hr_application_id)->update(['is_latest_trial_round' => false, 'is_latest' => false]);
            $this->update(['is_latest_trial_round' => true, 'is_latest' => true]);
        } else {
            self::where('hr_application_id', $this->hr_application_id)->update(['is_latest' => false]);
            $this->update(['is_latest' => true]);
        }
    }
}
