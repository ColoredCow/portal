<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Modules\HR\Entities\Application;
use Modules\HR\Jobs\Recruitment\SendEmailToNonVerifiedApplicants;

class DailyMessage extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:message-for-email-verified';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $siganture = 'hr:message-for-email-verified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to non verified applicants.';

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
        $applications = Application::where('is_verified', false)->where('created_at', '>=', '2022-07-06')->get();
        SendEmailToNonVerifiedApplicants::dispatch($applications);
  
    }
}