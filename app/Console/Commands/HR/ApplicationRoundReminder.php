<?php

namespace App\Console\Commands\HR;

use Illuminate\Console\Command;
use App\Models\HR\ApplicationRound;

class ApplicationRoundReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $applicationRounds = ApplicationRound::all();
    }
}
