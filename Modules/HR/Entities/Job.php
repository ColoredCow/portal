<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HR\Events\Recruitment\JobUpdated;
use Modules\User\Entities\User;

class Job extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'type', 'domain', 'start_date', 'description', 'posted_by', 'link', 'end_date', 'status', 'facebook_post', 'instagram_post', 'twitter_post', 'linkedin_post'];

    protected $table = 'hr_jobs';

    public function applications()
    {
        return $this->hasMany(Application::class, 'hr_job_id');
    }

    public function rounds()
    {
        return $this->belongsToMany(Round::class, 'hr_jobs_rounds', 'hr_job_id', 'hr_round_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer_id');
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }

    public function exceptTrialRounds()
    {
        return $this->rounds()->where('in_trial_round', false);
    }

    public function trialRounds()
    {
        return $this->rounds()->where('in_trial_round', true);
    }

    /**
     * Custom update method that updates a job and fires specific events.
     *
     * @param  array $attr      fillables to be updated
     * @return bool|mixed    true if update is successful, error object if update fails
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

    public function scopeIsVolunteer($query)
    {
        return $query->filterByType('volunteer');
    }

    public function scopeTypeVolunteer($query)
    {
        return $query->where('type', 'volunteer');
    }

    public function scopeTypeRecruitment($query)
    {
        return $query->whereIn('type', [
            'job',
            'internship',
        ]);
    }
}
