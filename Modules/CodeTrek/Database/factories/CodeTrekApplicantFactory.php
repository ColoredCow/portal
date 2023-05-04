<?php

namespace Modules\CodeTrek\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Faker\Factory as Faker;

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
        $faker = Faker::create();

        return [
            'first_name'=>$faker->name,
            'last_name'=>$faker->lastName,
            'email'=>$faker->email,
            'github_user_name'=>$faker->userName,
            'phone'=>$faker->phoneNumber,
            'course'=>$faker->word,
            'start_date'=>$faker->date($format = 'Y-m-d', $max = 'now'),
            'graduation_year'=>$faker->year($min = 'now')
        ];
    }
}
