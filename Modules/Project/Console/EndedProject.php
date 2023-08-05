<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Emails\EndedProjectMail;
use Modules\Project\Services\ProjectService;

class EndedProject extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:ended-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send projects to the project key account manager when the project date ends.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = app(ProjectService::class);
        $projectsData = $service->getMailDetailsForProjectKeyAccountManagers();
        foreach ($projectsData as $projectData) {
            Mail::queue(new EndedProjectMail($projectData));
        }
    }
}
