<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('projects')->delete();

        \DB::table('projects')->insert([
            0 => [
                'id' => 1,
                'type' => 'monthly-billing',
                'name' => 'Project 01',
                'client_id' => '1',
                'client_project_id' => null,
                'status' => null,
                'effort_sheet_url' => null,
                'total_estimated_hours' => null,
                'monthly_estimated_hours' => '160',
                'start_date' => null,
                'end_date' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'type' => 'monthly-billing',
                'name' => 'Project 02',
                'client_id' => '2',
                'client_project_id' => null,
                'status' => null,
                'effort_sheet_url' => null,
                'total_estimated_hours' => null,
                'monthly_estimated_hours' => '160',
                'start_date' => null,
                'end_date' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
