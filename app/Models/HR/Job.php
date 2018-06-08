<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'type', 'posted_by', 'link', 'facebook_post', 'instagram_post', 'twitter_post', 'linkedin_post'];

    protected $table = 'hr_jobs';

    public function applications()
    {
        return $this->hasMany(Application::class, 'hr_job_id');
    }

    public function rounds()
    {
        return $this->belongsToMany(Round::class, 'hr_jobs_rounds', 'hr_job_id', 'hr_round_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer_id');
    }

    /**
     * Custom update method that updates a job and fires specific events
     *
     * @param  array $attr      fillables to be updated
     * @return boolean|mixed    true if update is successful, error object if update fails
     */
    public function _update($attr)
    {
        $updated = $this->update($attr);

        if (isset($attr['rounds'])) {
            $this->rounds()->sync($attr['rounds']);
        }

        $request = request();
        event(new JobUpdated($this, [
            'rounds' => $request->input('rounds'),
        ]));
        return $updated;
    }

    public function getApplicantsByStatus($status = '')
    {
        return $this->applicants->where('status', $status);
    }

    public function scopeFilterByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeIsJob($query)
    {
        return $query->filterByType('job');
    }

    public function scopeIsInternship($query)
    {
        return $query->filterByType('internship');
    }
}
