<?php

namespace App\Models\HR;

use App\Models\HR\Applicant;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'posted_by', 'link', 'facebook_post', 'instagram_post', 'twitter_post', 'linkedin_post'];

    protected $table = 'hr_jobs';

    public function applicants()
    {
    	return $this->hasMany(Applicant::class, 'hr_job_id');
    }

    public function getApplicantsByStatus($status = '')
    {
    	return $this->applicants->where('status', $status);
    }

    public function rounds()
    {
        return $this->belongsToMany(Round::class, 'hr_jobs_rounds', 'hr_job_id', 'hr_round_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer');
    }
}
