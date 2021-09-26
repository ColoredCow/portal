<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HrApplicantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hr_applicants')->insert([
            'name' => 'coloredcow_hr',
            'email' => 'hr@coloredcow.com',
            'phone' => '102345678',
            'linkedin' => 'coloredcow',
            'course' => 'Marketing',
            'graduation_year' => '2022',
            'college' => 'coloredcow_university',
            'created_at' => '2021-09-26 11:59:10',
            'updated_at' => '2021-09-26 11:59:10'
        ]);
    }
}
