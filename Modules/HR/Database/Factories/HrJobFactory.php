<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Modules\HR\Entities\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrJobFactory extends Factory
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
            'id'=> $index,
            'opportunity_id'=> $faker->randomDigit,
            'title'=>  $faker->title,
            'description'=> $faker->text,
            'type'=> $faker->sentence(2),
            'domain'=> $faker->text,
            'start_date'=> $faker->date,
            'link'=> 'https=>//coloredcow.com/career/laravel-developer/',
            'end_date'=> $faker->date,
            'facebook_post'=> $faker->text,
            'twitter_post'=> $faker->text,
            'linkedin_post'=> $faker->text,
            'instagram_post'=> $faker->text,
            'created_at'=> $faker->date,
            'updated_at'=> $faker->date,
            'posted_by'=> 8,
            'status'=> $faker->text,
            'deleted_at'=> $faker->date
        ];
    }
}
