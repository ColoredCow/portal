<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Project\Console\SyncEffortsheet;
use Modules\Project\Console\ZeroEffortInProject;
use Modules\Project\Console\EndedProject;
use Modules\Project\Console\ZeroExpectedHourInProject;
use Modules\Project\Console\FixedBudgetProject;
use Modules\Project\Console\SendEffortSummaryCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Project\Console\GoogleChat\NotificationToProjectTeamMembersToUpdateEffortOnGoogleChat;
use Modules\HR\Console\JobExpiredEmailToHr;
use Modules\HR\Console\SystemReviewQuaterly;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SyncEffortsheet::class,
        SendEffortSummaryCommand::class,
        ZeroEffortInProject::class,
        ZeroExpectedHourInProject::class,
        EndedProject::class,
        FixedBudgetProject::class,
        NotificationToProjectTeamMembersToUpdateEffortOnGoogleChat::class,
        JobExpiredEmailToHr::class,
        SystemReviewQuaterly::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('application:no-show')->dailyAt('21:00');
        $schedule->command('application:send-interview-reminders')->dailyAt('08:00');
        $schedule->command('sync:effortsheet')->weekdays()->timezone(config('constants.timezone.indian'))->hourlyAt(25);
        $schedule->command('effort-summary:send')->weekdays()->timezone(config('constants.timezone.indian'))->at('21:00');
        $schedule->command('hr:check-follow-ups')->daily();
        $schedule->command('hr:send-follow-up-mail')->dailyAt('08:00');
        $schedule->command('hr:message-for-email-verified')->dailyAt('7:00');
        $schedule->command('hr:send-job-expired-email-to-hr')->dailyAt('11:00');
        $schedule->command('mapping-of-jobs-and-hr-rounds');
        $schedule->command('project:fixed-budget-project');
        $schedule->command('invoice:send-unpaid-invoice-list')->weekly()->mondays()->at('09:00');
        $schedule->command('project:zero-effort-in-project')->weekly()->mondays()->at('09:00');
        $schedule->command('project:ended-project')->dailyAt('09:00');
        $schedule->command('project:zero-expected-hours-in-project')->weekly()->tuesdays()->at('11:00');
        $schedule->command('project:reminder-for-effortsheet-lock')->dailyAt('21:00');
        $schedule->command('hr:quarterly-review-system')->quarterly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
