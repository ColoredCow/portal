<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicantsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Applicant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' =>  $this->faker->phoneNumber(),
            'course' => array_rand(config('hr.opportunities.domains')),
            'college' => $this->faker->word(),
            'graduation_year' =>  $this->faker->year(),
            'linkedin' => $this->faker->url(),
        ];
    }
}
