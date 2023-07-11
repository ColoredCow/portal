<?php

namespace Modules\CodeTrek\Services;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\HR\Entities\Job;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;
use Illuminate\Support\Facades\Mail;
use Modules\CodeTrek\Emails\CodeTrekApplicantRoundMail;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\ApplicationRound;

class CodeTrekRoundDetailService
{
    public function update($data, $applicantDetail)
    {
        $applicantDetail->feedback = $data->input('feedback');
        $applicantDetail->save();

        return $applicantDetail;
    }

    public function takeAction($data, $id)
    {
        $applicant = CodeTrekApplicant::findOrFail($id);
        $applicant->latest_round_name = $data->input('round');
        $applicant->save();

        $this->takeActionApplicantToRound($applicant);
        $this->codetrekApplicantStore($applicant);
        $this->codetrekApplicationStore($applicant);
        // $this->codetrekApplicantRoundStore($applicant);

        return $applicant;
    }

    public function codetrekApplicationStore($applicant)
    {
        $hrApplication = new Application();
        
        $hrApplication->hr_applicant_id = $applicant->id;
        $hrApplication->hr_job_id = 38;
        $hrApplication->status = config('constants.hr.status.sent-for-approval.label');
        $hrApplication->hr_channel_id = 1;
        $hrApplication->applicant_type = 'codetrek';
        $hrApplication->is_verified = 0;
        $hrApplication->offer_letter = $applicant->null;
        $hrApplication->resume = $applicant->null;
        $hrApplication->autoresponder_subject = $applicant->null;
        $hrApplication->autoresponder_body = $applicant->null;
        $hrApplication->pending_approval_from = $applicant->null;

        $hrApplication->save();
    }

    public function codetrekApplicantStore($applicant)
    {
        $hrApplicant = new Applicant();
        
        $hrApplicant->name = $applicant->first_name;
        $hrApplicant->email = $applicant->email;
        $hrApplicant->phone = $applicant->phone;
        $hrApplicant->wa_optin_at = $applicant->null;
        $hrApplicant->linkedin = $applicant->null;
        $hrApplicant->hr_university_id = $applicant->null;
        $hrApplicant->course = $applicant->course;
        $hrApplicant->graduation_year = $applicant->graduation_year;
        $hrApplicant->college = $applicant->university;
        
        $hrApplicant->save();
    }
    
    // public function codetrekApplicantRoundStore($hrApplication)
    // {
    //     $hrApplicationRound = new ApplicationRound();
        
    //     $hrApplicationRound->hr_application_id = $hrApplication->id;
    //     $hrApplicationRound->hr_round_id = 1;
    //     $hrApplicationRound->trial_round_id = 'null';
    //     $hrApplicationRound->calendar_event = 'null';
    //     $hrApplicationRound->calendar_meeting_id = 'null';
    //     $hrApplicationRound->scheduled_date = today();
    //     $hrApplicationRound->scheduled_end = today();
    //     $hrApplicationRound->actual_end_time = 'null';
    //     $hrApplicationRound->scheduled_person_id = 'null';
    //     $hrApplicationRound->conducted_date = 'null';
    //     $hrApplicationRound->conducted_person_id = 'null';
    //     $hrApplicationRound->round_status = 'null';
    //     $hrApplicationRound->is_latest = 'null';
        
    //     $hrApplicationRound->save();
    // }

    public function takeActionApplicantToRound($applicant)
    {
        $applicationRound = new CodeTrekApplicantRoundDetail;
        $applicationRound->applicant_id = $applicant->id;
        $applicationRound->latest_round_name = $applicant->latest_round_name;
        $applicationRound->feedback = null;
        $applicationRound->start_date = today();
        $codetrekApplicant = CodeTrekApplicant::find($applicant->id);
        // Mail::send(new CodeTrekApplicantRoundMail($applicationRound, $codetrekApplicant)); This line will be uncommented in the future when the use of the codeTrek module starts in the proper way.
        $applicationRound->save();
    }
}
