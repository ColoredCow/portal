<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use App\Models\Tag;
use App\Traits\HasTags;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Emails\Recruitment\Applicant\SendFollowUpReminder;

class FollowUpReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:need-follow-up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to the candidate if an application has a need to follow up tag associated with it';

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
        $applications = Application::all();
        $applications->load(['evaluations', 'evaluations.evaluationParameter', 'evaluations.evaluationOption', 'job', 'job.rounds', 'job.rounds.evaluationParameters', 'job.rounds.evaluationParameters.options', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.evaluations', 'applicationRounds.round', 'applicationMeta', 'applicationRounds.followUps', 'tags']);
        foreach ($applications as $application) {
            foreach($application->tags as $tag) {
                if($tag->slug === "need-follow-up") {
                    Mail::send(new SendFollowUpReminder($application));
                }	
            }
        }
    }
}
