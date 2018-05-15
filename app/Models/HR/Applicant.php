<?php

namespace App\Models\HR;

use App\Events\HR\ApplicantCreated;
use App\Events\HR\ApplicantUpdated;
use App\Models\HR\ApplicantRound;
use App\Models\HR\Application;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $guarded = [];

    protected $table = 'hr_applicants';

    /**
     * Custom create method that creates an applicant and fires specific events
     *
     * @param  array $attr  fillables to be stored
     * @return this
     */
    public static function _create($attr)
    {
        $applicant = self::create($attr);
        $application = Application::create([
            'hr_job_id' => $attr['hr_job_id'],
            'hr_applicant_id' => $applicant->id
        ]);
        event(new ApplicantCreated($applicant));
        return $applicant;
    }

    /**
     * Custom update method that updates an applicant and fires specific events
     *
     * @param  array $attr       fillables to be updated
     * @return boolean|object    true if update is successful, error object if update fails
     */
    public function _update($attr)
    {
        $updated = $this->update($attr);
        $request = request();
        event(new ApplicantUpdated($this, [
            'round_id' => $request->input('round_id'),
            'round_status' => $request->input('round_status'),
            'reviews' => $request->input('reviews'),
        ]));
        return $updated;
    }

    public function getApplicantRound($round_id)
    {
        return $this->applicantRounds->where('hr_round_id', $round_id)->first();
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'hr_applicant_id');
    }

    public function applicantRounds()
    {
    	return $this->hasMany(ApplicantRound::class, 'hr_applicant_id');
    }
}
