<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HR\Events\Recruitment\JobUpdated;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HR\Database\Factories\HrJobsFactory;
use App\Models\Resource;

class Job extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['opportunity_id', 'title', 'type', 'domain', 'start_date', 'description', 'posted_by', 'link', 'end_date', 'status', 'facebook_post', 'instagram_post', 'twitter_post', 'linkedin_post', 'hr_resource_category_id', 'job_id'];

    protected $table = 'hr_jobs';

    public function applications()
    {
        return $this->hasMany(Application::class, 'hr_job_id');
    }

    public function jobRequisition()
    {
        return $this->hasMany(JobRequisition::class, 'job_id')->where('status', 'pending');
    }

    public function rounds()
    {
        return $this->belongsToMany(Round::class, 'hr_jobs_rounds', 'hr_job_id', 'hr_round_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer_id');
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'job_id');
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

    public static function newFactory()
    {
        return new HrJobsFactory();
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
