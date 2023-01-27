<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\HRRejectionReason;

class HrApplicationRejectionReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            HRRejectionReason::factory()
                ->count(10)
                ->create();
        }
    }
}
