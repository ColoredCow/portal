<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Emails\DailyEffortsNotification;
use Modules\Project\Services\ProjectService;

class DailyEffortAlertNotificationMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:Daily-effort-mail-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily alert to team member if efforts logged are less than expected in a Project';

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
     *  @return mixed
     */
    public function handle()
    {
        $AlertService = new ProjectService();
        $getProjectDetailForDailyAlert = $AlertService->getProjectDetailForDailyAlert();
        if (!empty($getProjectDetailForDailyAlert)) {
            foreach ($getProjectDetailForDailyAlert as $users) {
                Mail::send(new DailyEffortsNotification($users));
            }
        }
    }
}
