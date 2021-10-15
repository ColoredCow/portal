<?php

namespace Modules\HR\Database\Factories;

use Carbon\Carbon;
use Modules\HR\Entities\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrJobsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'title' => array_rand(config('hr.opportunities')),
            //'type' => array_rand(config('hr.opportunities')),
            'domain' => array_rand(config('hr.opportunities.domains')),
            'status' => array_rand(config('hr.status')),
        ];
    }
    
}