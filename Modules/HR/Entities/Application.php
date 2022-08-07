<?php

namespace Modules\HR\Entities;

use App\Helpers\ContentHelper;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\HR\Entities\Evaluation\ApplicationEvaluation;
use Modules\HR\Events\Recruitment\ApplicationCreated;
use Modules\User\Entities\User;
use Modules\HR\Database\Factories\HrApplicationsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasTags,HasFactory;

    protected $guarded = ['id'];

    protected $table = 'hr_applications';

    public function job()
    {
        return $this->belongsTo(Job::class, 'hr_job_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'hr_applicant_id');
    }

    public function applicationRounds()
    {
        return $this->hasMany(ApplicationRound::class, 'hr_application_id');
    }

    /**
     * To fetch the application rounds which are in Trial program.
     */
    public function trialApplicationRounds()
    {
        return $this->applicationrounds()->whereHas('round', function ($subQuery) {
            return $subQuery->where('name', 'Trial Program');
        });
    }

    /**
     * To fetch the application rounds which are not in Trial program.
     */
    public function applicationRoundsExceptTrial()
    {
        return $this->applicationrounds()->whereHas('round', function ($subQuery) {
            return $subQuery->whereNotIn('name', ['Trial Program']);
        });
    }

    public function evaluations()
    {
        return $this->hasMany(ApplicationEvaluation::class);
    }

    public function applicationMeta()
    {
        return $this->hasMany(ApplicationMeta::class, 'hr_application_id');
    }

    public function pendingApprovalFrom()
    {
        return $this->belongsTo(User::class, 'pending_approval_from');
    }

    /**
     * Custom create method that creates an application and fires necessary events.
     *
     * @param  array $attr  fillables to be stored
     */
    public static function _create($attr)
    {
        $resume_file = $attr['resume_file'] ?? null;

        if ($resume_file) {
            $attr['resume'] = self::saveResumeFile($resume_file);
        }
        unset($attr['resume_file']);
        $application = self::create($attr);
        event(new ApplicationCreated($application));

        return $application;
    }

    public static function newFactory()
    {
        return new HrApplicationsFactory();
    }

    /**
     * Apply filters on application.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeApplyFilter($query, array $filters)
    {
        foreach (array_filter($filters) as $type => $value) {
            switch ($type) {
                case 'status':
                    $query->filterByStatus($value);
                    break;
                case 'job-type':
                    $query->filterByJobType($value);
                    break;
                case 'job':
                    $query->filterByJob($value);
                    break;
                case 'university':
                    $query->filterByUniversity($value);
                    break;
                case 'name':
                    $query->filterByName($value);
                    break;
                case 'tags':
                    $query->filterByTags($value);
                    break;
                case 'assignee':
                    $query->filterByAssignee($value);
                    break;
                case 'search':
                    $query->filterByKeyword($value);
                    break;
                case 'round':
                    $query->filterByRoundName($value);
            }
        }

        return $query;
    }

    /**
     * Apply filter on applications based on their show status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFilterByStatus($query, $status)
    {
        switch ($status) {
            case config('hr.status.rejected.label'):
                $query->rejected();
                break;
            case 'closed':
                $query->closed();
                break;
            case config('hr.status.on-hold.label'):
                $query->onHold();
                break;
            case config('hr.status.no-show.label'):
                $query->noShow();
                break;
            case config('hr.status.sent-for-approval.label'):
                $query->sentForApproval();
                break;
            case config('hr.status.approved.label'):
                $query->approved();
                break;
            case config('hr.status.onboarded.label'):
                $query->onboarded();
                break;
            case config('hr.status.in-progress.label'):
                $query->inProgress();
                break;
            default:
                $query->isOpen();
                break;
        }

        return $query;
    }

    /**
     * Apply filter on applications based on their job type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFilterByJobType($query, $type)
    {
        return $query->whereHas('job', function ($subQuery) use ($type) {
            $functionName = 'is' . $type;
            $subQuery->{$functionName}();
        });
    }

    public function scopeFilterByUniversity($query, $id)
    {
        return $query->whereHas('applicant', function ($query) use ($id) {
            $query->where('hr_university_id', $id);
        });
    }

    public function scopeFilterByName($query, $search)
    {
        return $query->whereHas('applicant', function ($query) use ($search) {
            ($search) ? $query->where('name', 'LIKE', "%$search%") : '';
        });
    }

    public function scopeFilterByKeyword($query, $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->whereHas('applicant', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%");
            $query->orWhere('email', 'LIKE', "%$search%");
            $query->orWhere('phone', 'LIKE', "%$search%");
            $query->orWhereHas('university', function ($universityQuery) use ($search) {
                $universityQuery->where('name', 'LIKE', "%$search%");
            });
        });
    }

    /**
     * Apply filter on applications based on the applied job.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFilterByJob($query, $id)
    {
        return $query->where('hr_job_id', $id);
    }

    /**
     * Apply filter on applications based on their Round Name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFilterByRoundName($query, $round)
    {
        return $query->whereHas('latestApplicationRound', function ($subQuery) use ($round) {
            return $subQuery->where('is_latest', true)
                ->whereHas('round', function ($subQuery) use ($round) {
                    return $subQuery->where('name', $round);
                });
        });
    }

    public function scopeFilterByAssignee($query, $id)
    {
        return $query->whereHas('latestApplicationRound', function ($subQuery) use ($id) {
            return $subQuery->where('is_latest', true)->where('scheduled_person_id', $id);
        });
    }

    public function latestApplicationRound()
    {
        return $this->hasOne(ApplicationRound::class, 'hr_application_id')->latest('id');
    }

    /**
     * Get applications where status is rejected.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', config('hr.status.rejected.label'))
        ->orderBy('updated_at', 'DESC');
    }

    /**
     * Get closed applications.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', config('hr.status.rejected.label'))
        ->orderBy('updated_at', 'DESC');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', config('hr.status.approved.label'))
        ->orderBy('updated_at', 'DESC');
    }

    public function scopeOnboarded($query)
    {
        return $query->where('status', config('hr.status.onboarded.label'))
        ->orderBy('updated_at', 'DESC');
    }

    /**
     * get applications where status is new and in-progress.
     */
    public function scopeIsOpen($query)
    {
        return $query->whereIn('status', [config('hr.status.new.label'), config('hr.status.in-progress.label')])
            ->whereHas('latestApplicationRound', function ($subQuery) {
                return $subQuery->where('is_latest', true)
                    ->whereHas('round', function ($subQuery) {
                        return $subQuery->whereNotIn('name', ['Trial Program']);
                    });
            });
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', config('hr.status.in-progress.label'));
    }

    /**
     * get applications where status is on-hold.
     */
    public function scopeOnHold($query)
    {
        return $query->where('status', config('hr.status.on-hold.label'))
        ->orderBy('updated_at', 'DESC');
    }

    /**
     * get applications where status is no-show.
     */
    public function scopeNoShow($query)
    {
        return $query->whereIn('status', [
            config('hr.status.no-show.label'),
            config('hr.status.no-show-reminded.label'),
        ])
        ->orderBy('updated_at', 'DESC');
    }

    /**
     * Get applications where status is sent-for-approval.
     */
    public function scopeSentForApproval($query)
    {
        return $query->where('status', config('hr.status.sent-for-approval.label'))
        ->orderBy('updated_at', 'DESC');
    }

    /**
     * Set application status to rejected.
     */
    public function reject()
    {
        $this->update(['status' => config('hr.status.rejected.label')]);
    }

    /**
     * Set application status to approved.
     */
    public function approve()
    {
        $this->update(['status' => config('hr.status.approved.label')]);
    }

    public function onHold()
    {
        $this->update(['status' => config('hr.status.on-hold.label')]);
    }

    public function onboarded()
    {
        $this->update(['status' => config('hr.status.onboarded.label')]);
    }

    /**
     * Set application status to in-progress.
     */
    public function markInProgress()
    {
        $this->update(['status' => config('hr.status.in-progress.label')]);
    }

    /**
     * Set the application status to sent-for-approval and also set the requested user as pending approval from.
     *
     * @param  int $userId
     * @return void
     */
    public function sendForApproval($userId)
    {
        $this->update([
            'status' => config('hr.status.sent-for-approval.label'),
            'pending_approval_from' => $userId,
        ]);
    }

    /**
     * Set the application status to no-show.
     */
    public function markNoShow()
    {
        $this->update(['status' => config('hr.status.no-show.label')]);
    }

    /**
     * Set the application status to no-show.
     */
    public function markNoShowReminded()
    {
        $this->update(['status' => config('hr.status.no-show-reminded.label')]);
    }

    /**
     * Get the timeline for an application.
     *
     * @return array
     */
    public function timeline()
    {
        $this->load('applicationRounds', 'applicationRounds.round');
        $timeline = [];
        foreach ($this->applicationRounds as $applicationRound) {
            if ($applicationRound->conducted_date) {
                $timeline[] = [
                    'type' => 'round-conducted',
                    'application' => $this,
                    'applicationRound' => $applicationRound,
                    'date' => $applicationRound->conducted_date,
                ];
            }
        }
        foreach ($this->trialApplicationRounds as $applicationRound) {
            if ($applicationRound->conducted_date) {
                $timeline[] = [
                    'type' => 'round-conducted',
                    'application' => $this,
                    'applicationRound' => $applicationRound,
                    'date' => $applicationRound->conducted_date,
                ];
            }
        }

        // adding change-job events in the application timeline
        $jobChangeEvents = $this->applicationMeta()->jobChanged()->get();
        foreach ($jobChangeEvents as $event) {
            $details = json_decode($event->value);
            $details->previous_job = Job::find($details->previous_job)->title;
            $details->new_job = Job::find($details->new_job)->title;
            $details->user = User::find($details->user)->name;
            $event->value = $details;
            $timeline[] = [
                'type' => config('hr.application-meta.keys.change-job'),
                'event' => $event,
                'date' => $event->created_at,
            ];
        }

        // adding no-show and no-show-reminded events in the application timeline
        $noShowEvents = $this->applicationMeta()->noShow()->get();
        foreach ($noShowEvents as $event) {
            $details = json_decode($event->value);
            $details->round = ApplicationRound::find($details->round)->round->name;
            $event->value = $details;
            $timeline[] = [
                'type' => config('hr.application-meta.keys.no-show'),
                'event' => $event,
                'date' => $event->created_at,
            ];
        }

        $sentForApprovalEvents = $this->applicationMeta()->sentForApproval()->get();
        foreach ($sentForApprovalEvents as $event) {
            $details = json_decode($event->value);
            $details->conductedPerson = User::find($details->conducted_person_id)->name;
            $details->supervisor = User::find($details->supervisor_id)->name;
            $event->value = $details;
            $timeline[] = [
                'type' => config('hr.application-meta.keys.sent-for-approval'),
                'event' => $event,
                'date' => $event->created_at,
            ];
        }

        $approvedEvents = $this->applicationMeta()->approved()->get();
        foreach ($approvedEvents as $event) {
            $details = json_decode($event->value);
            if (! $approver = User::find($details->approved_by)) {
                continue;
            }
            $details->approvedBy = $approver->name;
            $event->value = $details;
            $timeline[] = [
                'type' => config('hr.application-meta.keys.approved'),
                'event' => $event,
                'date' => $event->created_at,
            ];
        }

        $onboardEvents = $this->applicationMeta()->onboarded()->get();
        foreach ($onboardEvents as $event) {
            $details = json_decode($event->value);
            $details->onboardedBy = User::find($details->onboarded_by)->name;
            $event->value = $details;
            $timeline[] = [
                'type' => config('hr.application-meta.keys.onboarded'),
                'event' => $event,
                'date' => $event->created_at,
            ];
        }

        $customEmails = $this->applicationMeta()->customMail()->get();
        foreach ($customEmails as $event) {
            $details = json_decode($event->value, true);
            $event->value = $details;
            $custom_email = [
                'modal-id' => 'custom_mail_' . $event->id,
                'mail-to' => $this->applicant->email,
                'mail-subject' => $details['mail-subject'] ?? 'No subject',
                'mail-body' => $details['mail-body'] ?? 'No body',
                'mail-sender' => $details['mail-sender'] ?? '',
                'mail-date' => $event->created_at,
            ];

            $timeline[] = [
                'type' => config('hr.application-meta.keys.custom-mail'),
                'event' => $event,
                'title' => $details['title'] ?? $details['action'] ?? 'No Title',
                'mail_data' => $custom_email,
                'date' => $event->created_at,
            ];
        }

        return $timeline;
    }

    /**
     * Change the job for an application.
     */
    public function changeJob($attr)
    {
        $meta = [
            'previous_job' => $this->hr_job_id,
            'new_job' => $attr['hr_job_id'],
            'job_change_mail_subject' => $attr['job_change_mail_subject'],
            'job_change_mail_body' => ContentHelper::editorFormat($attr['job_change_mail_body']),
            'user' => auth()->id(),
        ];

        $this->update(['hr_job_id' => $attr['hr_job_id']]);

        return ApplicationMeta::create([
            'hr_application_id' => $this->id,
            'key' => config('hr.application-meta.keys.change-job'),
            'value' => json_encode($meta),
        ]);
    }

    /**
     * Check if the current Application instance has status either no-show or no-show-reminded.
     *
     * @return bool
     */
    public function isNoShow()
    {
        return in_array($this->status, [
            config('hr.status.no-show.label'),
            config('hr.status.no-show-reminded.label'),
        ]);
    }

    public function isSentForApproval()
    {
        return $this->status == config('hr.status.sent-for-approval.label');
    }

    public function isApproved()
    {
        return $this->status == config('hr.status.approved.label');
    }

    public function isRejected()
    {
        return $this->status == config('hr.status.rejected.label');
    }

    /** We need to change this approch, adding this because of current implementation of the application resume workflow */
    public static function saveResumeFile($file)
    {
        $folder = '/resume/' . date('Y') . '/' . date('m');
        $fileName = $file->getClientOriginalName();
        $file = Storage::disk('public')->putFileAs($folder, $file, $fileName, 'public');

        return '/storage/' . $file;
    }

    public function getScheduleInterviewLink()
    {
        $params = encrypt(json_encode(['application_id' => $this->id]));

        return route('select-appointments', $params);
    }

    public function getMarksAttribute()
    {
        if ($this->evaluations->isEmpty()) {
            return;
        }

        return $this->evaluations->sum(function ($evaluation) {
            return $evaluation->evaluationOption->marks;
        });
    }
}
