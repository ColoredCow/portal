<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Evaluation\ApplicationEvaluation;

class ApplicationEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ApplicationEvaluations = ApplicationEvaluation::with('applicationRound')->get();

        foreach ($ApplicationEvaluations as $applicationEvaluation) {
            $applicationEvaluation->application_id = $applicationEvaluation->applicationRound->hr_application_id;
            $applicationEvaluation->save();
        }
    }
}
