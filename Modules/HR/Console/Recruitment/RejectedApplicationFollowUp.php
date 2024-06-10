<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\SendApplicationRejectionMail;
use Modules\HR\Entities\Applicant;
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
        $applications = Application::with('latestApplicationRound')->isOpen()->whereHas('applicationRounds', function ($query) {
            $query->whereNull('scheduled_date')->whereNotNull('scheduled_person_id')->whereNull('round_status');
        })->get();

        foreach ($applications as $application) {
            $applicationRound = $application->latestApplicationRound;
            if($applicationRound->getPreviousApplicationRound()){
            $awaitingForDays = $applicationRound->getPreviousApplicationRound()->conducted_date->diffInDays(today());
                if($awaitingForDays >10){
                $hrApplicationId = $application->id;
                $updateStatus = Application::where('id', $hrApplicationId)->update(['status'=> 'rejected']);
                $hrApplicantId = Application::where('id', $hrApplicationId)->first()->hr_applicant_id;
                $applicantEmailId = Applicant::where('id', $hrApplicantId)->first()->email;
                Mail::to(config('hr.default.email'))->send(new SendApplicationRejectionMail($applicantEmailId));
                }
            } else{
                return;
            }
        }
    }

}
