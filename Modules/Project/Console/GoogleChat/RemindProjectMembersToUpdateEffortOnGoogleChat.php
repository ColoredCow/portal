<?php

namespace Modules\Project\Console\GoogleChat;

use Illuminate\Console\Command;
use Modules\Project\Entities\Project;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Project\Notifications\GoogleChat\RemindToUpdateEffort;

class RemindProjectMembersToUpdateEffortOnGoogleChat extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:remind-to-update-effort';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a simple notification that reminds a Google Chat channel to update their effort.';

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
        $projects = Project::with('getTeamMembers')->whereHas('teamMembers')->where('status', 'active')->get();
        foreach ($projects as $project) {
            if ($project->google_chat_webhook_url) {
                Notification::route('googleChat', $project->google_chat_webhook_url)->notify(new RemindToUpdateEffort($project));
            }
        }
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
