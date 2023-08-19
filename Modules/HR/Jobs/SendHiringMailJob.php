<?php

namespace Modules\HR\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendHiringMail;

class SendHiringMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $jobHiring;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jobHiring)
    {
        $this->jobHiring = $jobHiring;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::queue(new sendHiringMail($this->jobHiring));
    }
}
