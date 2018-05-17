<?php

namespace App\Models\HR;

use App\Events\HR\ApplicationCreated;
use App\Models\HR\Applicant;
use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id'];

    protected $table = 'hr_applications';

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
     * get list of applications based on their show status
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
        return $query->orderBy('id', 'desc')->paginate(config('constants.pagination_size'));
    }

    public function scopeFilterApplicationByJobType($query, $type = 'all')
    {
        switch ($type) {
            case 'job':
            case 'internship':
                return $query->whereHas('job', function ($sub_query) use ($type) {
                    $sub_query->where('type', $type);
                });
                break;
            default:
        }

        return $query;
    }

    public function scopeGetAllApplication($query)
    {
        return $query->filterApplicationByJobType();
    }

    public function scopeGetJobApplication($query)
    {
        return $query->filterApplicationByJobType('job');
    }

    public function scopeGetInternshipApplication($query)
    {
        return $query->filterApplicationByJobType('internship');
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
        return $this->hasOne(ApplicationMeta::class, 'hr_application_id');
    }
}
