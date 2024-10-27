<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\Recruitment\Applicant\ScheduledInterviewReminder;
use Modules\HR\Emails\Recruitment\InterviewerScheduledRoundsReminder;
use Modules\HR\Entities\ApplicationRound;
use Modules\User\Entities\User;

class SendInterviewReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:send-interview-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to the interviewers as well as applicants for the interviews scheduled for today';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get application rounds for the day grouped by the interviewer
        $applicationRounds = ApplicationRound::scheduledForToday();

        foreach ($applicationRounds as $scheduledPersonId => $rounds) {
            // We already have User instance as $round->scheduledPerson for each round. There is a scope
            // of optimization by using this instance and removing the User::find query below.
            $interviewer = User::find($scheduledPersonId);
            // send reminder emails to the scheduled interviewer
            Mail::to($interviewer->email, $interviewer->name)->send(new InterviewerScheduledRoundsReminder($rounds));

            // send reminder emails to the applicant for each application round
            foreach ($rounds as $applicationRound) {
                if ($applicationRound->round->reminder_enabled) {
                    Mail::send(new ScheduledInterviewReminder($applicationRound));
                }
            }
        }
    }
}
