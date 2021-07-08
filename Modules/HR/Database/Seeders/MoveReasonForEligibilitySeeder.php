<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;

class MoveReasonForEligibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applications = Application::all();
        foreach ($applications as $application) {
            if (is_null($application->reason_for_eligibility)) {
                continue;
            }
            $appMeta = ApplicationMeta::formData()->where('hr_application_id', $application->id)->first();
            if (is_null($appMeta)) {
                $appMeta = ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'form-data',
                    'value' => json_encode(['Reason for eligibility' => $application->reason_for_eligibility]),
                ]);
                continue;
            }
            $appMetaValue = json_decode($appMeta->value, true);
            if (array_key_exists('Reason for eligibility', $appMetaValue)) {
                continue;
            }
            $appMetaValue['Reason for eligibility'] = $application->reason_for_eligibility;
            $appMeta->value = json_encode($appMetaValue);
            $appMeta->save();
        }
    }
}
