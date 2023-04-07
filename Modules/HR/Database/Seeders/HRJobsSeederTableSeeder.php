<?php

namespace Modules\HR\Database\Seeders;

use Modules\HR\Entities\Job;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

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
                ->count(10)
                ->create();
        }
        Artisan::call('mapping-of-jobs-and-hr-rounds');
    }
}
