<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobRoundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hr_jobs_rounds')->insert([
            'hr_job_id' => 1,
            'hr_round_id' => 1,
        ]);
    }
}
