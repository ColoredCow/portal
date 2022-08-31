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
            Application::factory()
              ->count(60)
              ->create();
        }
    }
}
