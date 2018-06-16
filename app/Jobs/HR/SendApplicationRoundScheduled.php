<?php

namespace App\Jobs\HR;

use App\Models\HR\ApplicationRound;
use App\Notifications\HR\ApplicationRoundScheduled;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendApplicationRoundScheduled implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $applicationRound;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

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
