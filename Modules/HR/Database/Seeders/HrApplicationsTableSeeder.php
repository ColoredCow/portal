<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Application;

class HrApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            $applications = Application::factory()
            ->count(10)
            ->create();

            foreach ($applications as $application) {
                $application->tag($application->status);
            }
        }
    }
}
