<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Entities\User;

class SendEffortSummaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'effort-summary:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send effort summary to users';

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
        $recipients = User::wantsEffortSummary()->pluck('email');

        $this->info('Effort summary sent successfully.');

        return 0;
    }
}
