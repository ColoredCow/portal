<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendApplicationRejectionMail;
use Modules\HR\Entities\Application;

class RejectedApplicationFollowUp extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:send-application-close-mail-to-candidate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mails to candidates who has not scheduled to introductory call';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::to(config('hr.default.email'))->send(new SendApplicationRejectionMail());
    }

}
