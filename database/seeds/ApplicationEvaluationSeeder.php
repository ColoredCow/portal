<?php

use App\Models\HR\Evaluation\ApplicationEvaluation;
use Illuminate\Database\Seeder;

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
