<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        if (! app()->environment('production')) {
            ApplicationEvaluationSegment::factory()
                ->count(4)
                ->create();

            // $this->call("OthersTableSeeder");
        }
    }
}
