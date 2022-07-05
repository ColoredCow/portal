<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
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
        $faker = Faker::create();

        return [
            'opportunity_id' => 0,
            'title' => $faker->jobTitle,
            'description' => $faker->text(),
            'type' => config('hr.opportunities.job.type'),
            'domain' => array_rand(config('hr.opportunities.domains')),
            'start_date' => null,
            'link' => null,
            'end_date' => null,
            'facebook_post' => null,
            'twitter_post' => null,
            'linkedin_post' => null,
            'instagram_post' => null,
            'created_at' => null,
            'updated_at' => null,
            'posted_by' => null,
            'status' => array_rand(config('hr.opportunities-status')),
            'deleted_at' => null,
        ];
    }
}
