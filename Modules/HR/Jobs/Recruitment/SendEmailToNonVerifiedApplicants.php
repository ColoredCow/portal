<?php

namespace Modules\HR\Jobs\Recruitment;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\sendEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailToNonVerifiedApplicants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $applications;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applications)
    {
        $this->applications = $applications;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    
    }
}
