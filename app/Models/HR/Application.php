<?php

namespace App\Models\HR;

use App\Events\HR\ApplicationCreated;
use App\Models\HR\Applicant;
use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function applicationMeta()
    {
        return $this->hasMany(ApplicationMeta::class, 'hr_application_id');
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
            default:
                $query->nonRejected();
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
     * get applications where status is rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', config('constants.hr.status.rejected.label'));
    }

    /**
     * get applications where status is not rejected
     */
    public function scopeNonRejected($query)
    {
        return $query->where('status', '!=', config('constants.hr.status.rejected.label'));
    }

    /**
     * Set application status to rejected
     */
    public function reject()
    {
        $this->update(['status' => config('constants.hr.status.rejected.label')]);
    }

    /**
     * Set application status to in-progress
     */
    public function markInProgress()
    {
        $this->update(['status' => config('constants.hr.status.in-progress.label')]);
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
        return $timeline;
    }

    // /**
    //  * Change the job for an application
    //  *
    //  * @return void
    //  */
    // public function changeJob($attr)
    // {
    //     $changeJob = [
    //         'date' => Carbon::now()->format(config('constants.date_format')),
    //         'previous_job' => $this->hr_job_id,
    //         'new_job' => $attr['hr_job_id'],
    //         'change_job_mail_subject' => $attr['change_job_mail_subject'],
    //         'change_job_mail_body' => $attr['change_job_mail_body'],
    //     ];

    //     $this->update(['hr_job_id' => $attr['hr_job_id']]);

    //     if (!$this->applicationMeta) {
    //         ApplicationMeta::create([
    //             'hr_application_id' => $this->id,
    //             'form_data' => json_encode([ 'change-job' => $changeJob ])
    //         ]);
    //     } else {
    //         $formData = json_decode($this->applicationMeta->form_data);
    //         if (!isset($form_data['change-job'])) {
    //             $form_data['change-job'] = [];
    //         }
    //         $form_data['change-job'][] = $changeJob;
    //         $this->applicationMeta->update(['form_data' => json_encode($form_data)]);
    //     }
    // }
}
