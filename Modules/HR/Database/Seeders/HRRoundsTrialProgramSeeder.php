<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;

class HRRoundsTrialProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $round = Round::create(['name' => 'Trial Program']);

        $jobs = Job::all();
        foreach ($jobs as $job) {
            $job->rounds()->attach($round->id);
        }
    }
}
