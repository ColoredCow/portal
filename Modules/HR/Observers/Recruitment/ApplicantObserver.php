<?php
namespace Modules\HR\Observers\Recruitment;

use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\University;
use Modules\HR\Entities\UniversityAlias;

class ApplicantObserver
{
    /**
     * Listen to the Applicant create event.
     *
     * @param  Applicant $applicant
     * @return void
     */
    public function created(Applicant $applicant)
    {
        $data = request()->all();

        if (isset($data['college'])) {
            $university = University::select('id')->where('name', $data['college'])->first();
            if (! $university) {
                $universityAlias = UniversityAlias::select('hr_university_id')->where('name', $data['college'])->first();
                if (! $universityAlias) {
                    $university = University::create(['name'=>$data['college']]);
                    $applicant->update(['hr_university_id' => $university->id]);
                } else {
                    $applicant->update(['hr_university_id' => $universityAlias->hr_university_id]);
                }

                return;
            }
            $applicant->update(['hr_university_id' => $university->id]);
        }
    }
}
