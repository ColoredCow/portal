<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Job;
use Illuminate\Database\Eloquent\Model;

class HRJobsSeederTableSeeder extends Seeder
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
            Job::factory()
                ->count(2)
                ->create();
        }
        \Artisan::call('mapping-of-jobs-and-hr-rounds');
    }
}
