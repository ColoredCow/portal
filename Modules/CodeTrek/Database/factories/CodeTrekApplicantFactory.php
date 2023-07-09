<?php

namespace Modules\CodeTrek\Database\Factories;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodeTrekApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = CodeTrekApplicant::class;
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
