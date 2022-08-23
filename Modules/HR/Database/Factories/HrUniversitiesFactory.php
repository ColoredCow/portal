<?php

namespace Modules\HR\Database\Factories;

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
        return [
            'name' => $this->getCollegeNames()[array_rand($this->getCollegeNames())],
            'address' => $this->faker->address,
            'rating' => $this->getRating()[array_rand($this->getRating())],
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

    private function getRating()
    {
        return [
            '7.6',
            '9.5',
            '8.0',
            '5.3',
            '6.0',
            '7.9',
            '5.5'
        ];
    }
}
