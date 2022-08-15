<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\FollowUp;

class HrFollowUpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            FollowUp::factory()
                ->count(5)
                ->create();

            // $this->call("OthersTableSeeder");
        }
    }
}
