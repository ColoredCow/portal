<?php
namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Modules\HR\Entities\HRJobsRounds;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;

class MappingOfJobsAndHrRounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mapping-of-jobs-and-hr-rounds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will map all the jobs with the hrRounds. This has to be run whenever new HR Rounds are added.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Job::get() as $job) {
            foreach (Round::get() as $round) {
                HRJobsRounds::updateOrCreate(
                    [
                        'hr_job_id' => $job->id,
                        'hr_round_id' => $round->id,
                    ]
                );
            }
        }
    }
}
