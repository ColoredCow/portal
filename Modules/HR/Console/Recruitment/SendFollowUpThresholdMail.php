<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendThreshholdFollowUp;
use Modules\HR\Entities\Application;
use Modules\User\Entities\User;

class SendFollowUpThresholdMail extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:send-follow-up-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'After 2 followup threshold attempts.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applications = Application::whereIn('status', ['new', 'in-progress'])->get();
        $applications = $applications->reject(function ($application) {
            $followUpCount = $application->latestApplicationRound ? $application->latestApplicationRound->followUps->count() : 0;
            if ($followUpCount == config('hr.follow-up-attempts-threshold')) {
                return $application;
            }
        });

        foreach (config('hr.hr-followup-email') as $email) {
            $user = User::where('email', $email)->first();
            if (! $user) {
                continue;
            }
            Mail::to(config('hr.hr-followup-email'))->queue(new SendThreshholdFollowUp($applications, $user));
        }
    }
}
