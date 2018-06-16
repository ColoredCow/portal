<?php

use App\Models\HR\Job;
use App\Models\HR\Round;
use Illuminate\Database\Seeder;

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
