<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\University;
use Modules\HR\Entities\UniversityAlias;

class HrUniversityAliasesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UniversityAlias::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'hr_university_id' => University::factory()->create()->id,
            'name'=> $this->faker->name,

        ];
    }
}
