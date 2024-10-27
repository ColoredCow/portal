<?php

namespace Modules\HR\Console\Recruitment;

use App\Mail\SendEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\Application;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applications = Application::where('is_verified', false)->where('created_at', '>=', config('hr.non-verified-application-start-date'))->get();
        Mail::to(config('hr.default.non-verified-email'))->queue(new SendEmail($applications));

        $this->info('email sent successfully.');
    }
}
