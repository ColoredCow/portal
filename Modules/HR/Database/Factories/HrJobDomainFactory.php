<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\HR\Entities\HrJobDomain;

class HrJobDomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HrJobDomain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'domain'=> $faker->sentence(),
            'slug' => Str::slug($faker->sentence()),
        ];
    }
}
