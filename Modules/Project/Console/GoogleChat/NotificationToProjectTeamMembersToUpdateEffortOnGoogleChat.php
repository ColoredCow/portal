<?php

namespace Modules\Project\Console\GoogleChat;

use Illuminate\Console\Command;
use Modules\Project\Entities\Project;
use Illuminate\Support\Facades\Notification;
use Modules\Project\Notifications\GoogleChat\NotificationToUpdateEffortForProject;

class NotificationToProjectTeamMembersToUpdateEffortOnGoogleChat extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:reminder-for-effortsheet-lock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a simple notification on a Google Chat channel to update their effort before the end date.';

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
            if ($project->google_chat_webhook_url && $project->effort_sheet_url) {
                Notification::route('googleChat', $project->google_chat_webhook_url)->notify(new NotificationToUpdateEffortForProject($project));
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
