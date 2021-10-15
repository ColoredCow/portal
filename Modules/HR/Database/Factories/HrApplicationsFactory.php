<?php

namespace Modules\HR\Database\Factories;

use Carbon\Carbon;
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
            'hr_applicant_id' => function () {
                return Applicant::factory()->create()->id;
            },
            'hr_job_id' => function () {
                return Job::factory()->create()->id;
            },
            'status' => array_rand(config('hr.status'))
        ];
    }
    
}