<?php

namespace Modules\HR\Entities;

use App\Services\GSuiteUserService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrApplicantsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\HR\Entities\HrChannel;

class Applicant extends Model
{
    use Notifiable, HasFactory;

    protected $guarded = [];

    protected $table = 'hr_applicants';

    /**
     * Custom create method that creates an applicant and fires specific events.
     *
     * @param  array $attr  fillables to be stored
     */
    public static function _create($attr)
    {
        $applicant = self::firstOrCreate([
            'email' => $attr['email'],
        ], [
            'name' => $attr['name'],
            'phone' => isset($attr['phone']) ? $attr['phone'] : null,
            'wa_optin_at' => isset($attr['wa_optin_at']),
            'college' => isset($attr['college']) ? $attr['college'] : null,
            'graduation_year' => isset($attr['graduation_year']) ? $attr['graduation_year'] : null,
            'course' => isset($attr['course']) ? $attr['course'] : null,
            'linkedin' => isset($attr['linkedin']) ? $attr['linkedin'] : null,
        ]);

        $job = Job::where('opportunity_id', $attr['opportunity_id'])->first();
        $hr_channel_id = ($attr['hr_channel_id']) ?? HrChannel::select('id')->where('name', 'Website')->first()->id;
        $application = Application::_create([
            'hr_job_id' => $job->id,
            'hr_applicant_id' => $applicant->id,
            'resume' => $attr['resume'] ?? '',
            'resume_file' => $attr['resume_file'] ?? '',
            'status' => $applicant->wasRecentlyCreated ? config('constants.hr.status.new.label') : config('constants.hr.status.on-hold.label'),
            'hr_channel_id' => $hr_channel_id,
        ]);

        if (isset($attr['form_data'])) {
            $application_meta = ApplicationMeta::create([
                'hr_application_id' => $application->id,
                'key' => config('constants.hr.application-meta.keys.form-data'),
                'value' => json_encode($attr['form_data']),
            ]);
        }

        $applicant->wasRecentlyCreated ? $application->tag('new-application') : null;

        return $applicant;
    }

    public static function newFactory()
    {
        return new HrApplicantsFactory();
    }

    /**
     * Get all applications for the applicant which are new and in-progress.
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
     * Get the timeline for an applicant.
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
        /* @phpstan-ignore-next-line */
        array_multisort(array_map(function ($element) {
            return $element['date'];
        }, $timeline), SORT_ASC, $timeline);

        return $timeline;
    }

    /**
     * Determines if the applicant has graduated or not.
     *
     * @return bool
     */
    public function hasGraduated()
    {
        return $this->graduation_year ? $this->graduation_year <= Carbon::now()->year : 'esss';
    }

    public function onboard($email, $password, $params = [])
    {
        $gsuiteUser = new GSuiteUserService;
        $gsuiteUser->create($this->splitName(), $email, $password, $params);
    }

    public function splitName()
    {
        $name = trim($this->name);
        $lastName = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $firstName = trim(preg_replace('#' . $lastName . '#', '', $name));

        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
        ];
    }

    /**
     * Get the applicant's university.
     */
    public function university()
    {
        return $this->hasOne(University::class, 'id', 'hr_university_id');
    }

    public function getLinkedinAttribute($value)
    {
        if (strpos($value, 'http') !== 0) {
            return 'https://' . $value;
        }

        return $value;
    }
}
