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
use Modules\Project\Console\GoogleChat\SendDailyEffortSummaryForProjectsOnGoogleChat;
use Modules\Project\Console\GoogleChat\RemindProjectMembersToUpdateEffortOnGoogleChat;
use App\Console\Commands\Testcron;

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
        SendDailyEffortSummaryForProjectsOnGoogleChat::class,
        RemindProjectMembersToUpdateEffortOnGoogleChat::class,
        Testcron::class,
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
        $schedule->command('sync:effortsheet')->weekdays()->timezone(config('constants.timezone.indian'))->everyFourHours();
        $schedule->command('effort-summary:send')->weekdays()->timezone(config('constants.timezone.indian'))->at('21:00');
        $schedule->command('hr:check-follow-ups')->daily();
        $schedule->command('hr:send-follow-up-mail')->dailyAt('08:00');
        $schedule->command('hr:message-for-email-verified')->dailyAt('7:00');
        $schedule->command('mapping-of-jobs-and-hr-rounds');
        $schedule->command('project:fixed-budget-project');
        $schedule->command('invoice:send-unpaid-invoice-list')->weekly()->mondays()->at('09:00');
        $schedule->command('project:zero-effort-in-project')->weekly()->mondays()->at('09:00');
        $schedule->command('project:ended-project')->dailyAt('09:00');
        $schedule->command('project:remind-to-update-effort')->weekdays()->at('19:00');
        $schedule->command('project:send-daily-effort-summary-google-chat')->weekdays()->at('22:30');
        $schedule->command('project:zero-expected-hours-in-project')->weekly()->tuesdays()->at('11:00');
        $schedule->command('sendmail:cron')->everyMinute();
    
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
