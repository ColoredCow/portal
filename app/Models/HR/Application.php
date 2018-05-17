<?php

namespace App\Models\HR;

use App\Models\HR\Applicant;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id'];

    protected $table = 'hr_applications';

    public function scopeFilterApplicationByJobType($query, $type = 'all') {
        switch ($type) {
            case 'job':
                break;
            case 'internship':
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
}
