<?php

namespace Modules\CodeTrek\Services;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

class CodeTrekRoundDetailService
{
    public function update($data, $id)
    {
        $applicant = CodeTrekApplicant::findOrFail($id);
        $roundDetail = CodeTrekApplicantRoundDetail::firstOrCreate([
            'applicant_id' => $applicant->id,
            'round_name' => $data->round_name,
        ]);
        $roundDetail->round_name = $data->round_name;
        $roundDetail = CodeTrekApplicantRoundDetail::updateOrCreate(
            [
                'id' => $data->primary_id,
            ],
            [
                'feedback' => $data->input('feedback'),
            ]
        );
        $roundDetail->save();

        return $roundDetail;
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
