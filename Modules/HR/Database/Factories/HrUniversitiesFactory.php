<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\University;

class HrUniversitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = University::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'name' => $this->getCollegeNames()[array_rand($this->getCollegeNames())],
            'address' => $this->faker->address,
            'rating' => $faker->numerify('#.#'),
        ];
    }

    private function getCollegeNames()
    {
        return [
            'THDC-ihet',
            'Doon University',
            'AMU',
            'Delhi University',
            'chandigarh University',
            'Uttaranchal University',
            'Graphic-Era University',
        ];
    }
}
