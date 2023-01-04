<?php

namespace Modules\HR\Emails;

use App\Mail\ApplicationLifeCycleNotifcationEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\HR\Entities\Application;
use Illuminate\Support\Facades\Mail;

class ApplicationLifeCycleEmailTrigger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:application-lifecycle-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Streamline job application lifecycle';

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
     * @return int
     */
    public function handle()
    {
        $expiredApplicationTotalNumber = Application::whereIn('status', ['new', 'in_progress'])
        ->where('created_at', '<', Carbon::now()->subDays(config('hr.time-period.application_lifecycle_days')))
        ->count();

        return Mail::to(config('hr.application-lifecycle.email'))->queue(new ApplicationLifeCycleNotifcationEmail($expiredApplicationTotalNumber));
    }
}
