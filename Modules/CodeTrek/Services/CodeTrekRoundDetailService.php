<?php

namespace Modules\CodeTrek\Services;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

class CodeTrekRoundDetailService
{
    public function update($data,$id)
    {
        $applicant = CodeTrekApplicant::findOrFail($id);
        $roundDetail = CodeTrekApplicantRoundDetail::firstOrCreate([
                       'applicant_id' => $applicant->id,
                       'round_name' => $data->round_name,
        ]);
        $roundDetail->round_name = $data->round_name;
        $roundDetail->feedback = $data->input('feedback');
        $roundDetail->save();

        return $roundDetail;
    }

    public function takeAction($data,$id)
    {
        $applicant = CodeTrekApplicant::findOrFail($id);
        $applicant->round_name  =$data->input('round');
        $applicant->save();

        return $applicant;
    }
}
