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

    /**
     * Custom create method that creates a job and fires specific events
     *
     * @param  array $attr  fillables to be stored
     * @return this
     */
    public static function _create($attr)
    {
        $job = self::create($attr);
        event(new JobCreated($job));
        return $job;
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
        if(isset($attr['rounds'])) {
            $this->updateInterviewers($attr['rounds']);
        }

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
        return $this->belongsToMany(Round::class, 'hr_jobs_rounds', 'hr_job_id', 'hr_round_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer_id');
    }

    public function updateInterviewers($rounds = []) {
        foreach($rounds as $roundID => $round) {
            $this->assignInterviewer($roundID, $round['hr_round_interviewer_id']);
        }
    }

    public function assignInterviewer($roundID, $interviewerID) {
        $round = $this->rounds->find($roundID);
        if(!$round || !$interviewerID) {
            return false;
        }

        if(! ($pivotTable = $round->pivot)) {
            return false;
        }

        $pivotTable->hr_round_interviewer_id = $interviewerID;
        return $pivotTable->save();
    }
}
