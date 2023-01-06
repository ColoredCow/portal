<?php

namespace Modules\HR\Services;

use  Modules\HR\Entities\ApplicantMeta;
use Modules\HR\Http\Requests\ApplicantMetaRequest;

class ApplicantService
{
    public function storeApplicantOnboardingDetails(ApplicantMetaRequest $request)
    {
        $keyConfigs = (config('hr.applicant_form-details'));
        $uploadConfigs = (config('hr.applicant_upload_details'));
        $encryptConfigs = (config('hr.encrypted-applicant-details'));

        foreach ($keyConfigs as $key=>$label) {
            ApplicantMeta::updateOrCreate([
                'hr_applicant_id' => $request->get('hr_applicant_id'),
                'key' => $label,
                'value' => $request->get($key),
            ]);
        }

        foreach ($encryptConfigs as $key=>$label) {
            ApplicantMeta::updateOrInsert(
                [
                'key' => $label,
                'hr_applicant_id' => $request->get('hr_applicant_id'),
                ],
                [
                'hr_applicant_id' => $request->get('hr_applicant_id'),
                'key' => $label,
                'value' => encrypt($request->get($key)),
                ]
            );
        }

        foreach ($uploadConfigs as $key=>$label) {
            if ($request->file($key)) {
                $file = $request->file($key);
                $fileName = $key . $request->get('hr_applicant_id') . '.' . $file->extension();
                $filepath = $file->move(storage_path('app/public/Employee-Documents-Details'), $fileName);
                ApplicantMeta::updateOrInsert(
                    [
                    'key' => $label,
                    'hr_applicant_id' => $request->get('hr_applicant_id'),
                    ],
                    [
                    'hr_applicant_id' => $request->get('hr_applicant_id'),
                    'key' => $label,
                    'value' => $fileName,
                    ]
                );
            }
        }
    }
}
