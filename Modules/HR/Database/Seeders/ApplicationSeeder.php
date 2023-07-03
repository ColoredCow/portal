<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Job;
use Modules\User\Entities\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 200; $i++) {
            $faker = Faker::create();

            $applicantData = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
            ];
    
            $applicants = Applicant::create($applicantData);
            $applicantData = [
                'hr_applicant_id' => $applicants->id,
                'hr_job_id' => $this->generateRandomJobId(),
                'status' => $this->generateRandomStatus(),
                'pending_approval_from' => $this->generateRandomApproval(),
                'offer_letter' => $this->generateRandomPath(),
                'resume' => $this->generateRandomPath(),
            ];

            Application::create($applicantData);
        }
    }

    private function generateRandomApplicantId()
    {
        // Get a random hr_applicant_id from the existing applicants
        $applicant = Applicant::inRandomOrder()->first();
        return $applicant->id;
    }

    private function generateRandomJobId()
    {
        // Get a random hr_job_id from the existing jobs
        $job = Job::inRandomOrder()->first();
        return $job->id;
    }

    private function generateRandomStatus()
    {
        // Generate a random status ('pending', 'approved', 'rejected')
        $statuses = ['pending', 'approved', 'rejected'];

        return $statuses[array_rand($statuses)];
    }

    private function generateRandomApproval()
    {
        // Get a random user id from the existing users
        $user = User::inRandomOrder()->first();
        return $user->id;
    }

    private function generateRandomPath()
    {
        // Generate a random path for offer_letter and resume
        return 'path/to/' . Str::random(10) . '.pdf';
    }
}
