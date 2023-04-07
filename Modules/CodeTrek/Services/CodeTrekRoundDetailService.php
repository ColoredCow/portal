<?php

namespace Modules\CodeTrek\Services;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
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
        $applicant->round_name = $data->input('round');
        $applicant->save();

        $this->takeActionApplicantToRound($applicant);

        return $applicant;
    }

    public function takeActionApplicantToRound($applicant)
    {
        $applicationRound = new CodeTrekApplicantRoundDetail;
        $applicationRound->applicant_id = $applicant->id;
        $applicationRound->round_name = $applicant->round_name;
        $applicationRound->feedback = null;
        $applicationRound->start_date = today();
        $applicationRound->save();
    }
}
