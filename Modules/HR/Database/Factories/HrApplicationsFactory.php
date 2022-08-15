<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\Application;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Job;
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
            'hr_applicant_id' => Applicant::factory()->create()->id,
            'hr_job_id' => Job::factory()->create()->id,
            'resume' => 'https://coloredcow.com/wp-content/uploads/2022/08/sample.pdf',
            'status' => array_rand(config('hr.status'))
        ];
    }
}
