<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()->modify('-2 year');
        $createdDate = clone($date);
        DB::table('hr_job_domains')->insert([
            0 => [
                'domain_name' => 'Engineering',
                'slug' => 'engineering',
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ],
            1 => [
                'domain_name' => 'Design',
                'slug' => 'design',
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ],
            2 => [
                'domain_name' => 'Marketing',
                'slug' => 'marketing',
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ],
            3 => [
                'domain_name' => 'Data Researcher',
                'slug' => 'data-researcher',
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ],
            4 => [
                'domain_name' => 'People Operations',
                'slug' => 'people-operations',
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ],
            5 => [
                'domain_name' => 'Project Management',
                'slug' => 'project-management',
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ],

         ]);
    }
}
