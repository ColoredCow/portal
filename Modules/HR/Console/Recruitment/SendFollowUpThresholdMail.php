<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Modules\HR\Entities\Application;
use Modules\HR\Emails\sendThreshholdFollowUp;
use Illuminate\Support\Facades\Mail;

class sendFollowUpThresholdMail extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:send-follow-ups-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'After 2 followup threshold attempts.';

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
        $applications = Application::whereIn('status', ['new', 'in-progress'])->get();
        $applications = $applications->reject(function ($application) {
            // dd($application->latestApplicationRound);
            $applicationround = $application->latestApplicationRound;
            if ($applicationround) {
                $followUpCount = $application->latestApplicationRound->followUps->count();
                if ($followUpCount == config('hr.follow-up-attempts-threshold')) {
                    return $application;
                }
            }
        });
        $emails = ['deepak.sharma@colorecow.com', 'pk@coloredcow.com'];
        Mail::to($emails)->queue(new sendThreshholdFollowUp($applications));
    }
}
