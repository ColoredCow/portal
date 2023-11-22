<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;

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
            'slug' => Str::slug($designation),
        ];
    }
}
