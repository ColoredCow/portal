<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\ApplicationEvaluationSegment;

class HrApplicationSegmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            ApplicationEvaluationSegment::factory()
                ->count(2)
                ->create();
        }
    }
}
