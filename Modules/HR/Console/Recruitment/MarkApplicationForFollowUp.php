<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Modules\HR\Entities\Application;
use Modules\HR\Events\FollowUpEvent;

class MarkApplicationForFollowUp extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:check-follow-ups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for applications that need follow up. Adds the follow up tag if found true';

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
        $this->handleAwaitingCalendarConfirmationApplications();
    }

    /**
     * Handles the applications that are waiting for applicant to schedule interview.
     * @return void
     */
    public function handleAwaitingCalendarConfirmationApplications()
    {
        $applications = Application::with('latestApplicationRound')->isOpen()->whereHas('applicationRounds', function ($query) {
            $query->whereNull('scheduled_date')->whereNotNull('scheduled_person_id')->whereNull('round_status');
        })->get();

        foreach ($applications as $application) {
            $applicationRound = $application->latestApplicationRound;
            $previousRoundConductedOn = $applicationRound->getPreviousApplicationRound()->conducted_date;

            // check if the previous round has been conducted more than 3 days ago
            if ($previousRoundConductedOn->diffInDays(now()) > 3 && $applicationRound->round->name != 'Trial Program' && $applicationRound->round->name != 'Team Interaction Round') {
                $application->tag('need-follow-up');
                $followUpCount = $applicationRound->followUps->count();
                if ($followUpCount < config('hr.follow-up-attempts-threshold')) {
                    event(new FollowUpEvent($application));
                }
            }
        }
        $this->info('complete handleAwaitingCalendarConfirmationApplications');
    }
}
