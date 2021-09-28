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
            [
                'id' => 1,
                'title' => 'Software Developer',
                'type' => 'job',
                'domain' => 'engineering'
            ],
            [
                'id' => 2,
                'title' => 'Product Designer',
                'type' => 'job',
                'domain' => 'designer'
            ],
            [
                'id' => 3,
                'title' => 'Data Researcher',
                'type' => 'job',
                'domain' => 'marketing'
            ]
            ]);
    }
}
