<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Codetrek\Entities\CodeTrekApplicant;
use Faker\Factory as Faker;

class CodeTrekApplicantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 100; $i++) {
            $applicant = new CodeTrekApplicant;
            $applicant->first_name = $faker->firstName;
            $applicant->last_name = $faker->lastName;
            $applicant->email = $faker->email;
            $applicant->phone = 7819191919;
            $applicant->github_user_name = $faker->name;
            $applicant->start_date = $faker->date;
            $applicant->university = 'B.T.K.I.T';
            $applicant->course = 'btech';
            $applicant->graduation_year = $faker->year;
            $applicant->save();
        }
    }
}
