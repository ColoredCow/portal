<?php

namespace Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\University;
use Modules\HR\Entities\UniversityContact;

class HrUniversitiesContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UniversityContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hr_university_id' => University::factory()->create()->id,
            'name' => $this->faker->name,
            'designation' => $this->faker->text(),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
