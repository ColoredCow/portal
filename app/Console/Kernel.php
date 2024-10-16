<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\HR\Console\JobExpiredEmailToHr;
use Modules\Invoice\Console\SeedLoanInstallmentForMonth;
use Modules\Invoice\Console\UploadToGDrive;
use Modules\Project\Console\DeliveryReportReminder;
use Modules\Project\Console\EndedProject;
use Modules\Project\Console\FixedBudgetProject;
use Modules\Project\Console\GoogleChat\NotificationToProjectTeamMembersToUpdateEffortOnGoogleChat;
use Modules\Project\Console\SendEffortSummaryCommand;
use Modules\Project\Console\SyncEffortsheet;
use Modules\Project\Console\ZeroEffortInProject;
use Modules\Project\Console\ZeroExpectedHourInProject;

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
        DeliveryReportReminder::class,
        FixedBudgetProject::class,
        NotificationToProjectTeamMembersToUpdateEffortOnGoogleChat::class,
        JobExpiredEmailToHr::class,
        SeedLoanInstallmentForMonth::class,
        UploadToGDrive::class,
        // QuarterlyReviewSystemForEmployee::class, //This line will be commented for some time. After the feature is completed, it will be uncommented.

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('application:no-show')->dailyAt('21:00');
        $schedule->command('application:send-interview-reminders')->dailyAt('08:00');
        $schedule->command('sync:effortsheet')->hourlyAt(25)->timezone(config('constants.timezone.indian'));
        $schedule->command('effort-summary:send')->weekdays()->timezone(config('constants.timezone.indian'))->at('21:00');
        $schedule->command('hr:check-follow-ups')->daily();
        $schedule->command('hr:send-follow-up-mail')->dailyAt('08:00');
        $schedule->command('hr:message-for-email-verified')->dailyAt('7:00');
        $schedule->command('hr:send-job-expired-email-to-hr')->dailyAt('11:00');
        $schedule->command('mapping-of-jobs-and-hr-rounds');
        $schedule->command('project:fixed-budget-project');
        $schedule->command('project:send-pending-delivery-report-reminder')->dailyAt('11:00');
        $schedule->command('invoice:send-unpaid-invoice-list')->weekly()->mondays()->at('09:00');
        $schedule->command('invoice:send-upcoming-invoice-list')->dailyAt('11:00');
        $schedule->command('project:zero-effort-in-project')->weekly()->mondays()->at('09:00');
        $schedule->command('project:ended-project')->dailyAt('09:00');
        $schedule->command('project:zero-expected-hours-in-project')->weekly()->tuesdays()->at('11:00');
        $schedule->command('project:reminder-for-effortsheet-lock')->dailyAt('21:00');
        $schedule->command('loan:seed-loan-installment-for-month')->timezone(config('constants.timezone.indian'))->lastDayOfMonth('23:30');
        
        if (env('APP_ENV') == 'production') {
            $schedule->command('invoice:upload-to-gdrive')->timezone(config('constants.timezone.indian'))->monthlyOn(1, '01:00');
        }
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
