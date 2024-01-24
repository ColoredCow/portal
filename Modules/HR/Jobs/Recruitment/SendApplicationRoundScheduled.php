<?php

namespace Modules\HR\Jobs\Recruitment;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Notifications\Recruitment\ApplicationRoundScheduled;

class SendApplicationRoundScheduled implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    protected $applicationRound;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ApplicationRound $applicationRound)
    {
        $this->applicationRound = $applicationRound;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->applicationRound->scheduledPerson->notify(new ApplicationRoundScheduled($this->applicationRound));
    }
}
