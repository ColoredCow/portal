<?php

namespace Modules\HR\Database\Factories;

use Modules\User\Entities\User;
use Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;

class HrEmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        $user = User::factory()->create();

        return [
            'name' => $faker->name,
            'user_id' => $user->id,
            'designation_id' => optional(HrJobDesignation::inRandomOrder()->first())->id,
            'domain_id' => optional(HrJobDomain::inRandomOrder()->first())->id,
            'joined_on' => $faker->dateTimeThisYear(),
            'staff_type' => 'Employee',
        ];
    }
}
