<?php

namespace App\Models\HR;

use App\Events\HR\JobCreated;
use App\Events\HR\JobUpdated;
use App\Models\HR\Applicant;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'posted_by', 'link', 'facebook_post', 'instagram_post', 'twitter_post', 'linkedin_post'];

    protected $table = 'hr_jobs';

    public static function _create($attr)
    {
        $job = self::create($attr);
        event(new JobCreated($job));
        return $job;
    }

    public function _update($attr)
    {
        $updated = $this->update($attr);
        $request = request();
        event(new JobUpdated($this, [
            'rounds' => $request->input('rounds'),
        ]));
        return $updated;
    }

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
