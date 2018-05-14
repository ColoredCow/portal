<?php

use App\Models\HR\Applicant;
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
        		$originalApplicant->jobs()->attach($applicant->hr_job_id, [
        			'created_at' => $applicant->created_at,
        			'updated_at' => $applicant->updated_at,
        		]);

        		foreach($applicant->applicantRounds as $applicantRound) {
        			foreach ($applicantRound->applicantReviews as $applicantReview) {
        				echo $applicantReview->id;
        				$applicantReview->delete();
        			}
        			$applicantRound->delete();
        		}
        		$applicant->delete();

        		continue;
        	}
        	$uniqueApplicants[$applicant->email] = $applicant;
        	$applicant->jobs()->attach($applicant->hr_job_id, [
        		'created_at' => $applicant->created_at,
    			'updated_at' => $applicant->updated_at,
        	]);
        }
    }
}
