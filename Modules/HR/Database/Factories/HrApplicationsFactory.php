<?php

namespace Modules\HR\Database\Factories;

use Carbon\Carbon;
use Modules\HR\Entities\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hr_applicant_id' => function () {
                return Applicant::factory()->create()->id;
            },
            'hr_job_id' => function () {
                return Job::factory()->create()->id;
            },
            //pending_approval_from is having a default value as NULLs
        ];
    }
}
// 'hr_applicant_id' => '1',
        //     'hr_job_id' => '1',
        //     'status' => 'In Review',
        //     'offer_letter' => 'Pending',
        //     'resume' => 'abc_resume.pdf',
        //     'autoresponder_subject' => 'Thank you for applying!',
        //     'autoresponder_body' => 'We are reviewing your profile and checking if it is a good fit for the job! All the best!',
        //     'created_at' => '2021-09-26 12:13:17',
        //     'updated_at' => '2021-09-26 12:13:17'

