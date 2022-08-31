<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\ApplicationRoundReview;

class HrApplicationRoundReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            ApplicationRoundReview::factory()
                ->count(20)
                ->create();
        }
    }
}
