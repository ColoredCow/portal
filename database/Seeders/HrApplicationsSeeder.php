<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HrApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hr_applications')->insert([
            'hr_applicant_id' => '100',
            'hr_job_id' => '1089',
            'status' => 'In Review',
            'offer_letter' => 'Pending',
            'pending_approval_from' => 'CTO',
            'resume' => 'abc_resume.pdf',
            'autoresponder_subject' => 'Thank you for applying!',
            'autoresponder_body' => 'We are reviewing your profile and checking if it is a good fit for the job! All the best!',
            'created_at' => '2021-09-26 12:13:17',
            'updated_at' => '2021-09-26 12:13:17'
        ]);
    }
}
