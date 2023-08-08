<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\Round;

class HrApplicationRoundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            $applications = Application::all();
            foreach ($applications as $application) {
                if (! $application) {
                    continue;
                }

                $status = $application->status == 'new' ? 'new-application' : $application->status;
                if ($status == 'new-application' || $status == 'in-progress') {
                    $application->tag($status);
                } else {
                    $application->untag('in-progress');
                }

                ApplicationRound::updateOrCreate(
                    [
                        'hr_application_id' => $application->id,
                    ],
                    [
                        'hr_round_id' => Round::first()->id,
                        'scheduled_person_id' => Employee::factory()->create()->user_id,
                        'is_latest' => true,
                    ]
                );
            }
        }
    }
}
