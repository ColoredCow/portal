<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use Modules\Project\Notifications\GoogleChat\SendProjectSummary;

class SendDailyEffortSummaryForProjectsOnGoogleChat extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:send-daily-effort-summary-google-chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a daily effort summary for every project and send it to their respective Google Chat channels.';

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
        Notification::route('googleChat', 'chat-webhook-url')->notify(new SendProjectSummary);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
