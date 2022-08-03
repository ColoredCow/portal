<?php

namespace App\Console;

use Modules\Project\Console\SendEffortSummaryCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Project\Console\SyncEffortsheet;
use Modules\Project\Console\ZeroEffortInProject;
use Modules\Project\Console\DailyEffortAlertNotificationMail;

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
        DailyEffortAlertNotificationMail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('application:no-show')->everyThirtyMinutes();
        $schedule->command('application:send-interview-reminders')->dailyAt('08:00');
        $schedule->command('sync:effortsheet')->weekdays()->timezone(config('constants.timezone.indian'))->everyFourHours();
        $schedule->command('effort-summary:send')->weekdays()->timezone(config('constants.timezone.indian'))->at('21:00');
        $schedule->command('hr:check-follow-ups')->daily();
        $schedule->command('hr:message-for-email-verified')->dailyAt('7:00');
        $schedule->command('mapping-of-jobs-and-hr-rounds');
        $schedule->command('invoice:send-unpaid-invoice-list')->weekly()->mondays()->at('09:00');
        $schedule->command('project:zero-effort-in-project')->weekly()->mondays()->at('09:00');
        $schedule->command('users:daily-effort-mail-alert')->daily()->at('09:00');
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
