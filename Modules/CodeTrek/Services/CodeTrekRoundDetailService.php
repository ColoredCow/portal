<?php

namespace Modules\CodeTrek\Services;

use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Entities\ApplicationRound;
use Illuminate\Support\Facades\Mail;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Emails\CodeTrekApplicantRoundMail;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

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

        return $applicant;
    }

    public function takeActionApplicantToRound($applicant)
    {
        $applicationRound = new CodeTrekApplicantRoundDetail;
        $applicationRound->applicant_id = $applicant->id;
        $applicationRound->latest_round_name = $applicant->latest_round_name;
        $applicationRound->feedback = null;
        $applicationRound->start_date = today();
        $codetrekApplicant = CodeTrekApplicant::find($applicant->id);
        // Mail::send(new CodeTrekApplicantRoundMail($applicationRound, $codetrekApplicant)); This line will be uncommented in the future when the use of the codeTrek module starts in the proper way.
        $this->codetrekApplicantStore($applicant);
        $applicationRound->save();
    }

    public function codetrekApplicantStore($applicant)
    {

        $hrApplicant = new Applicant();
        $hrApplicant->name = $applicant->first_name . ' ' . $applicant->last_name;
        $hrApplicant->email = $applicant->email;
        $hrApplicant->phone = $applicant->phone;
        $hrApplicant->wa_optin_at = $applicant->null;
        $hrApplicant->linkedin = $applicant->null;
        $hrApplicant->hr_university_id = $applicant->null;
        $hrApplicant->course = $applicant->course;
        $hrApplicant->graduation_year = $applicant->graduation_year;
        $hrApplicant->college = $applicant->university;
        
        $hrApplicant->save();
        $this->codetrekApplicationStore($hrApplicant,$applicant);
    }

    public function codetrekApplicationStore($hrApplicant,$applicant)
    {
        $hrApplication = new Application();
        
        $hrApplication->hr_applicant_id = $hrApplicant->id;
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
        $this->codetrekApplicationMetaStore($hrApplication,$applicant);
        $this->codetrekApplicationRoundStore($hrApplication,$applicant);
    }

    public function codetrekApplicationMetaStore($hrApplication,$applicant)
    {
         ApplicationMeta::create([
            'hr_application_id' => $hrApplication->id,
            'value' => json_encode([
                'conducted_person_id' => $applicant->mentor_id,
                'supervisor_id' => $applicant->mentor_id,
            ]),
        ]);
    }

    public function codetrekApplicationRoundStore($hrApplication,$applicant)
    {
        $hrApplicationRound = new ApplicationRound();

        $hrApplicationRound->hr_application_id = $hrApplication->id;
        $hrApplicationRound->hr_round_id = 1;
        $hrApplicationRound->scheduled_person_id = 1;
        $hrApplicationRound->conducted_person_id = $applicant->mentor_id;
        
        $hrApplicationRound->save();
    }

}
