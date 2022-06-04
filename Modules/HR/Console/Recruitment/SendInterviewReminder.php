<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Modules\HR\Emails\InterviewReminder;
use Modules\HR\Entities\Application;

class SendInterviewReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:send-interview-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to the interviewers for the interviews scheduled for today';

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
        $currentDateTime = Carbon::now();
        $date = $currentDateTime->toDateString();
        $time = $currentDateTime->toTimeString();
        $applications = Application::all();
        $applications->load(['evaluations', 'evaluations.evaluationParameter', 'evaluations.evaluationOption', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.evaluations', 'applicationRounds.round', 'applicationMeta', 'applicationRounds.followUps']);
        foreach ($applications as $application) {
            foreach($application->applicationRounds as $applicationRound) {
                if ($date == $applicationRound->scheduled_date->toDateString()) {
                    if ($time > $applicationRound->scheduled_date->toTimeString()) {
                        Mail::to($applicationRound->scheduledPerson->email, $applicationRound->scheduledPerson->name)->send(new InterviewReminder($applicationRound, $application));
                    }
                }
            }
        }
    }
}
