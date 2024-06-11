<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendApplicationRejectionMail;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;

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
        $applications = Application::with('latestApplicationRound')->isOpen()->whereHas('applicationRounds', function ($query) {
            $query->whereNull('scheduled_date')->whereNotNull('scheduled_person_id')->whereNull('round_status');
        })->get();

        foreach ($applications as $application) {
            $applicationRound = $application->latestApplicationRound;
            if ($applicationRound->getPreviousApplicationRound()) {
                $awaitingForDays = $applicationRound->getPreviousApplicationRound()->conducted_date->diffInDays(today());
                if ($awaitingForDays > 10) {
                    $hrApplicationId = $application->id;
                    $jobId = $application->hr_job_id;
                    $interviewLink = $application->getScheduleInterviewLink();
                    $hrApplicantId = Application::where('id', $hrApplicationId)->first()->hr_applicant_id;
                    $jobTitle = Job::where('id', $jobId)->first()->title;
                    $updateStatus = Application::where('id', $hrApplicationId)->update([
                        'status' => 'rejected',
                        'is_unresponsive' => 1,
                    ]);
                    Mail::send(new SendApplicationRejectionMail($hrApplicantId, $jobTitle, $interviewLink));
                }
            } else {
                return;
            }
        }
    }
}
