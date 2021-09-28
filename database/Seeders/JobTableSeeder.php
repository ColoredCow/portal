<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hr_jobs')->insert([
                'id' => 1,
                'title' => 'India',
                'type' => 'job',
                'domain' => 'engineering',
            ]);
    }
}
