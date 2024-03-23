<?php

namespace Modules\HR\Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\HrJobDesignation;
use Modules\User\Entities\User;

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
            'joined_on' => $faker->dateTimeThisYear(),
            'staff_type' => 'Employee',
        ];
    }
}
