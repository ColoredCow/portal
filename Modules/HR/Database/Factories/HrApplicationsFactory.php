<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\Application;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Job;

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
        $status = array_rand(config('hr.status'));

        if ($status == 'custom-mail') {
            $status = 'sent-for-approval';
        } elseif ($status == 'confirmed') {
            $status = 'onboarded';
        }

        return [
            'hr_applicant_id' => Applicant::inRandomOrder()->first()->id,
            'hr_job_id' => Job::inRandomOrder()->first()->id,
            'resume' => config('hr.Sample-Resume'),
            'status' => $status
        ];
    }
}
