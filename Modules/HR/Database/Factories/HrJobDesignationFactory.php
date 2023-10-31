<?php

namespace Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class HrJobDesignationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HrJobDesignation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        $designation = $faker->jobTitle;

        return [
            'domain_id' => HrJobDomain::inRandomOrder()->first()->id,
            'designation' => $designation,
            'slug' => Str::slug($designation)
        ];
    }
}
