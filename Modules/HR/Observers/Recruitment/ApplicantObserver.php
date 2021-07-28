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
     * @param  \Modules\HR\Entities\Applicant  $Applicant
     * @return void
     */
    public function created(Applicant $applicant)
    {   $data = request()->all();
        if(isset($data['college']))
        {
            $university = University::select('id')->where('name', $data['college'])->first();
            if($university==null)
            {
                $universityAlias = UniversityAlias::select('hr_university_id')->where('name', $data['college'])->first();
                if($universityAlias==null)
                {
                    University::create(['name'=>$data['college']]);
                    $university = University::select('id')->where('name', $data['college'])->first();
                    $applicant->update(['hr_university_id' => $university->id]);
                }
                else
                {
                    $university = UniversityAlias::select('hr_university_id')->where('name', $data['college'])->first();
                    $applicant->update(['hr_university_id' => $university->hr_university_id]);
                }
            }
            else
            {
                $applicant->update(['hr_university_id' => $university->id]);
            }
        }
    }
}
