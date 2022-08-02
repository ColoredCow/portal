<?php

namespace Modules\Project\Console\GoogleChat;

use Illuminate\Console\Command;
use Modules\Project\Entities\Project;
use Illuminate\Support\Facades\Notification;
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
        $projects = Project::with(['getTeamMembers', 'getTeamMembers.user'])->whereHas('getTeamMembers')->where('status', 'active')->get();
        foreach ($projects as $project) {
            $projectNotificationData = [
                'projectName' => $project->name,
                'projectUrl' => route('project.effort-tracking', $project),
            ];
            foreach ($project->getTeamMembers->sortBy('user.name') as $teamMember) {
                $projectNotificationData['teamMembers'][] = [
                    'name' => $teamMember->user->name,
                    'velocity' => $teamMember->velocity,
                    'velocityColor' => $teamMember->velocity >= 1 ? '#38c172' : '#ff0000',
                ];
            }
            $projectGoogleChatWebhookUrl = $project->google_chat_webhook_url;
            if (count($projectNotificationData) && $projectGoogleChatWebhookUrl) {
                Notification::route('googleChat', $projectGoogleChatWebhookUrl)->notify(new SendProjectSummary($projectNotificationData));
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
