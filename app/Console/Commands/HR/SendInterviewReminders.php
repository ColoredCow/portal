<?php

namespace App\Console\Commands\HR;

use App\Mail\HR\Applicant\ScheduledInterviewReminder;
use App\Mail\HR\InterviewerScheduledRoundsReminder;
use App\Models\HR\ApplicationRound;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        $applicationRounds = ApplicationRound::scheduledForToday();

        $interviewers = [];
        foreach ($applicationRounds as $applicationRound) {
            if ($applicationRound->application && $applicationRound->application->job) {
                $interviewer = $applicationRound->scheduledPerson;
                if (!array_key_exists($interviewer->id, $interviewers)) {
                    $interviewers[$interviewer->id] = [];
                }
                $interviewers[$interviewer->id][] = $applicationRound;
            }
        }

        foreach ($interviewers as $id => $rounds) {
            // We already have User instance as $applicationRound->scheduledPerson. Instead of setting personId
            // as the key of $interviewers array, we need to figure out how the previous instance can be
            // directly used so that the below User::find query isn't needed.
            $interviewer = User::find($id);
            Mail::to($interviewer->email, $interviewer->name)->send(new InterviewerScheduledRoundsReminder($rounds));
        }

        // send mail to the applicants
        foreach ($applicationRounds as $applicationRound) {
            Mail::send(new ScheduledInterviewReminder($applicationRound));
        }
    }
}
