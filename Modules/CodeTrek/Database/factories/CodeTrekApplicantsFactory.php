<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Modules\CodeTrek\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class CodeTrekApplicantsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CodeTrekApplicant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'github_user_name' => $this->faker->userName,
            'phone' => $this->faker->phoneNumber,
            'status' => 'active',
            'course' => $this->faker->randomElement(['Computer Science', 'Engineering', 'Mathematics']),
            'start_date' => $this->faker->date(),
            'graduation_year' => $this->faker->year,
            'university' => $this->faker->company,
        ];
    }

}