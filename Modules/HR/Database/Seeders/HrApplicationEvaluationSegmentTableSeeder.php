<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Evaluation\Segment;

class HrApplicationEvaluationSegmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            Segment::factory()
                ->count(1)
                ->create();

            // $this->call("OthersTableSeeder");
        }
    }
}
