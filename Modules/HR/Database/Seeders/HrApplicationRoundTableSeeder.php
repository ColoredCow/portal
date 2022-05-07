<?php

namespace Modules\HR\Database\Seeders;

use Modules\HR\Entities\Job;
use Illuminate\Database\Seeder;
use Modules\HR\Entities\ApplicationRound;

class HrApplicationRoundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            Job::factory()->create();
            // ApplicationRound::factory()
            //     ->count(2)
            //     ->create();
        }
    }
}
