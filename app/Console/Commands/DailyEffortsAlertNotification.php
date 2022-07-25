<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DailyEffortsAlertNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyEffortsAlertNotification';

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
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
