<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        $applicant = self::firstOrCreate([
            'email' => $attr['email'],
        ], [
            'name' => $attr['name'],
            'phone' => isset($attr['phone']) ? $attr['phone'] : null,
            'college' => isset($attr['college']) ? $attr['college'] : null,
            'graduation_year' => isset($attr['graduation_year']) ? $attr['graduation_year'] : null,
            'course' => isset($attr['course']) ? $attr['course'] : null,
            'linkedin' => isset($attr['linkedin']) ? $attr['linkedin'] : null,
        ]);

        $job = Job::where('title', $attr['job_title'])->first();
        $application = Application::_create([
            'hr_job_id' => $job->id,
            'hr_applicant_id' => $applicant->id,
            'resume' => $attr['resume'],
            'reason_for_eligibility' => isset($attr['reason_for_eligibility']) ? $attr['reason_for_eligibility'] : null,
            'status' => $applicant->wasRecentlyCreated ? config('constants.hr.status.new.label') : config('constants.hr.status.on-hold.label'),
        ]);

        if (isset($attr['form_data'])) {
            $application_meta = ApplicationMeta::create([
                'hr_application_id' => $application->id,
                'key' => config('constants.hr.application-meta.keys.form-data'),
                'value' => json_encode($attr['form_data'])
            ]);
        }

        return $applicant;
    }

    /**
     * Get all applications for the applicant which are new and in-progress
     */
    public function openApplications()
    {
        return $this->applications()->isOpen()->get();
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'hr_applicant_id');
    }

    /**
     * Get the timeline for an applicant
     *
     * @return array
     */
    public function timeline()
    {
        $this->load('applications');
        $timeline = [];
        foreach ($this->applications as $application) {
            $timeline[] = [
                'type' => 'application-created',
                'application' => $application,
                'date' => $application->created_at,
            ];
            $timeline = array_merge($timeline, $application->timeline());
        }
        // Sort the timeline based on the date value in each subarray in the timeline.
        array_multisort(array_map(function ($element) {
            return $element['date'];
        }, $timeline), SORT_ASC, $timeline);
        return $timeline;
    }

    /**
     * Determines if the applicant has graduated or not
     *
     * @return boolean
     */
    public function hasGraduated()
    {
        return $this->graduation_year ? $this->graduation_year <= Carbon::now()->year : 'esss';
    }
}
