<?php

namespace Modules\HR\Emails;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\Application;

class Lifecycle_of_mail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:lifecycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Streamline job application life cycle';

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
     * @return int
     */
    public function handle()
    {
        $email = 'hr@coloredcow.com';
        $application_dates= Application::whereIn('status', ['new', 'in_progress'])->pluck('created_at');
        foreach ($application_dates as $date) {
            $difference_days = $date->diffInDays(now());
            $total_no_application = $application_dates->count();
            if ($difference_days>config('hr.time-period.outdated')) {
                Mail::send('emails.send-application-lifecycle', ['no_of_application'=>$total_no_application], function ($messge) use($email) {
                    $messge->to($email)->subject('Application Life-Cycle');
                });
            }
        }
    }
}
