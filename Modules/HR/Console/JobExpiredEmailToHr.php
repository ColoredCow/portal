<?php

namespace Modules\HR\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendJobExpiredMail;
use Modules\HR\Entities\Job;

class JobExpiredEmailToHr extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:send-job-expired-email-to-hr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send list of expired jobs to HR';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentDate = today();
        $jobs = Job::where([
            ['end_date', '<', $currentDate],
            ['status', 'published'],
        ])->get();
        if ($jobs->count() > 0) {
            Mail::to(config('hr.default.email'))->send(new SendJobExpiredMail($jobs));
        }
    }
}
