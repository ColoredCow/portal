<?php

namespace Modules\CodeTrek\Database\Factories;

use Carbon\Carbon;
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
            'start_date' => Carbon::today(),
            'university' =>$this->getCollegeNames()[array_rand($this->getCollegeNames())],
            'graduation_year'=>Carbon::now()->year,
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
