<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CodetrekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=1; $i<=5; $i++) {
            DB::table('code_trek_applicants')->insert([
            'first_name'=>$faker->name,
            'last_name'=>$faker->email,
            'email'=>$faker->email,
            'github_user_name'=>'test',
            'phone'=>'',
            'course'=>'',
            'start_date'=>'',
            'graduation_year'=>'',
            'university'=>'',
            'created_at'=>'',
            'updated_at'=>'',
            'deleted_at'=>'',
            'round_name'=>'level 1'
        ]);
        }
    }
}
