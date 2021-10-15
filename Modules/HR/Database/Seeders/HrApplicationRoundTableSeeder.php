<?php

namespace Modules\HR\Database\Seeders;

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
        ApplicationRound::factory()
            ->count(2)
            ->create();

        $this->call(HrApplicantsTableSeeder::class);
        $this->call(HrApplicationsTableSeeder::class);
    }
}
