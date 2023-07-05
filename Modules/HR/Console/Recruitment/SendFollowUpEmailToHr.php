<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Modules\HR\Entities\Application;
use Modules\User\Entities\User;
use Modules\HR\Emails\FollowUpEMailToHr;
use Illuminate\Support\Facades\Mail;

class SendFollowUpEmailToHr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:send-follow-up-mail-to-hr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending a Follow-Up Email to HR';

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
        $applications = Application::whereIn('status', ['new', 'in-progress'])->get();
        $filteredApplications = $applications->reject(function ($application) {
            $followUpCount = $application->latestApplicationRound ? $application->latestApplicationRound->followUps->count() : 0;
            if ($followUpCount == config('hr.follow-up-attempts-daily')) {
                return $application;
            }
        });

        foreach (config('hr.hr-followup-email') as $email) {
            $user = User::where('email', $email)->first();
            if (! $user) {
                continue;
            }
            Mail::to($email)->queue(new FollowUpEMailToHr($filteredApplications, $user));
        }

        return 0;  //for successfully execution
    }
}
