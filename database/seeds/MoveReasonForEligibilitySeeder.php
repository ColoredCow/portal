<?php

use App\Models\HR\Application;
use App\Models\HR\ApplicationMeta;
use Illuminate\Database\Seeder;

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
                continue;
            }
            $appMetaValue = json_decode($appMeta->value, true);
            $appMetaValue['Reason for eligibility'] = $application->reason_for_eligibility;
            $appMeta->value = json_encode($appMetaValue);
            $appMeta->save();
        }
    }
}
