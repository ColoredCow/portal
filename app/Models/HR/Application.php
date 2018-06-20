<?php

namespace App\Models\HR;

use App\Events\HR\ApplicationCreated;
use App\Helpers\ContentHelper;
use App\Models\HR\Evaluation\ApplicationEvaluation;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Application extends Model
{
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
     * Custom create method that creates an application and fires necessary events
     *
     * @param  array $attr  fillables to be stored
     * @return this
     */
    public static function _create($attr)
    {
        $application = self::create($attr);
        event(new ApplicationCreated($application));
        return $application;
    }

    /**
     * Apply filters on application
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Array $filters
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
                case 'name':
                    $query->filterByName($value);
                    break;
            }
        }

        return $query;
    }

    /**
     * Apply filter on applications based on their show status
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param String $status
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFilterByStatus($query, $status)
    {
        switch ($status) {
            case config('constants.hr.status.rejected.label'):
                $query->rejected();
                break;
            case 'closed':
                $query->closed();
                break;
            case config('constants.hr.status.on-hold.label'):
                $query->onHold();
                break;
            case config('constants.hr.status.no-show.label'):
                $query->noShow();
                break;
            case config('constants.hr.status.sent-for-approval.label'):
                $query->sentForApproval();
                break;
            default:
                $query->isOpen();
                break;
        }

        return $query;
    }

    /**
     * Apply filter on applications based on their job type
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param String $type
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFilterByJobType($query, $type)
    {
        $query->whereHas('job', function ($subQuery) use ($type) {
            $functionName = 'is' . $type;
            $subQuery->{$functionName}();
        });

        return $query;
    }

    public function scopeFilterByName($query, $search)
    {
        $query->whereHas('applicant', function ($query) use ($search) {
            ($search) ? $query->where('name', 'LIKE', "%$search%") : '';
        });

        return $query;
    }

    /**
     * Apply filter on applications based on the applied job
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param String $id
     *
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeFilterByJob($query, $id)
    {
        $query->where('hr_job_id', $id);

        return $query;
    }

    /**
     * Get applications where status is rejected.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', config('constants.hr.status.rejected.label'));
    }

    /**
     * Get closed applications.
     */
    public function scopeClosed($query)
    {
        return $query->whereIn('status', [
            config('constants.hr.status.rejected.label'),
            config('constants.hr.status.approved.label'),
        ]);
    }

    /**
     * get applications where status is new and in-progress
     */
    public function scopeIsOpen($query)
    {
        return $query->whereIn('status', array(config('constants.hr.status.new.label'), config('constants.hr.status.in-progress.label')));
    }

    /**
     * get applications where status is on-hold
     */
    public function scopeOnHold($query)
    {
        return $query->where('status', config('constants.hr.status.on-hold.label'));
    }

    /**
     * get applications where status is no-show
     */
    public function scopeNoShow($query)
    {
        return $query->whereIn('status', [
            config('constants.hr.status.no-show.label'),
            config('constants.hr.status.no-show-reminded.label'),
        ]);
    }

    /**
     * Get applications where status is sent-for-approval
     */
    public function scopeSentForApproval($query)
    {
        return $query->where('status', config('constants.hr.status.sent-for-approval.label'));
    }

    /**
     * Set application status to rejected
     */
    public function reject()
    {
        $this->update(['status' => config('constants.hr.status.rejected.label')]);
    }

    /**
     * Set application status to approved
     */
    public function approve()
    {
        $this->update(['status' => config('constants.hr.status.approved.label')]);
    }

    /**
     * Set application status to in-progress
     */
    public function markInProgress()
    {
        $this->update(['status' => config('constants.hr.status.in-progress.label')]);
    }

    /**
     * Set the application status to sent-for-approval and also set the requested user as pending approval from
     *
     * @param  integer $userId
     * @return void
     */
    public function sendForApproval($userId)
    {
        $this->update([
            'status' => config('constants.hr.status.sent-for-approval.label'),
            'pending_approval_from' => $userId,
        ]);
    }

    /**
     * Set the application status to no-show
     */
    public function markNoShow()
    {
        $this->update(['status' => config('constants.hr.status.no-show.label')]);
    }

    /**
     * Set the application status to no-show
     */
    public function markNoShowReminded()
    {
        $this->update(['status' => config('constants.hr.status.no-show-reminded.label')]);
    }

    /**
     * Get the timeline for an application
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

        // adding change-job events in the application timeline
        $jobChangeEvents = $this->applicationMeta()->jobChanged()->get();
        foreach ($jobChangeEvents as $event) {
            $details = json_decode($event->value);
            $details->previous_job = Job::find($details->previous_job)->title;
            $details->new_job = Job::find($details->new_job)->title;
            $details->user = User::find($details->user)->name;
            $event->value = $details;
            $timeline[] = [
                'type' => config('constants.hr.application-meta.keys.change-job'),
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
                'type' => config('constants.hr.application-meta.keys.no-show'),
                'event' => $event,
                'date' => $event->created_at,
            ];
        }

        return $timeline;
    }

    /**
     * Change the job for an application
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function changeJob($attr)
    {
        $meta = [
            'previous_job' => $this->hr_job_id,
            'new_job' => $attr['hr_job_id'],
            'job_change_mail_subject' => $attr['job_change_mail_subject'],
            'job_change_mail_body' => ContentHelper::editorFormat($attr['job_change_mail_body']),
            'user' => Auth::id(),
        ];

        $this->update(['hr_job_id' => $attr['hr_job_id']]);
        return ApplicationMeta::create([
            'hr_application_id' => $this->id,
            'key' => config('constants.hr.application-meta.keys.change-job'),
            'value' => json_encode($meta),
        ]);
    }

    /**
     * Check if the current Application instance has status either no-show or no-show-reminded.
     *
     * @return boolean
     */
    public function isNoShow()
    {
        return in_array($this->status, [
            config('constants.hr.status.no-show.label'),
            config('constants.hr.status.no-show-reminded.label'),
        ]);
    }

    public function isSentForApproval()
    {
        return $this->status == config('constants.hr.status.sent-for-approval.label');
    }

    public function isRejected()
    {
        return $this->status == config('constants.hr.status.rejected.label');
    }
}
