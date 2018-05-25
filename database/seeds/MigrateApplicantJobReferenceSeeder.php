<?php

use App\Models\HR\Applicant;
use App\Models\HR\Application;
use App\Models\HR\ApplicationReview;
use App\Models\HR\ApplicationRound;
use Illuminate\Database\Seeder;

class MigrateApplicantJobReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applicants = Applicant::all();

        $uniqueApplicants = [];
        foreach ($applicants as $applicant) {

            // checking if the current applicant entry is duplicate
            if (array_key_exists($applicant->email, $uniqueApplicants)) {

                // find the original applicant with the same email. $applicant is duplicate of $originalApplicant
                $originalApplicant = $uniqueApplicants[$applicant->email];

                // add the job of this duplicate applicant as the job of original applicant
                self::createApplication($applicant, $originalApplicant);

                $applicant->delete();

                continue;
            }
            $uniqueApplicants[$applicant->email] = $applicant;
            self::createApplication($applicant);
        }
    }

    public function createApplication($applicant, $originalApplicant = null)
    {
        // prepare attributes
        $attr = [
            'hr_job_id' => $applicant->hr_job_id,
            'hr_applicant_id' => $originalApplicant ? $originalApplicant->id : $applicant->id,
            'status' => $applicant->status,
            'resume' => $applicant->resume,
            'reason_for_eligibility' => $applicant->reason_for_eligibility,
            'autoresponder_subject' => $applicant->autoresponder_subject,
            'autoresponder_body' => $applicant->autoresponder_body,
            'created_at' => $applicant->created_at,
            'updated_at' => $applicant->updated_at,
        ];
        // create application
        $application = Application::create($attr);

        $applicationRounds = ApplicationRound::where('hr_applicant_id', $applicant->id)->get();

        // link all the applicant's rounds to the application created
        foreach ($applicationRounds as $applicationRound) {
            $applicationRound->hr_application_id = $application->id;
            $applicationRound->save();

            $applicationRoundReviews = ApplicationRoundReview::where('hr_applicant_round_id', $applicationRound->id)->get();

            // link all the applicant's round reviews to the application's round
            foreach ($applicationRoundReviews as $applicationRoundReview) {
                $applicationRoundReview->hr_application_round_id = $applicationRound->id;
                $applicationRoundReview->save();
            }
        }
    }
}
