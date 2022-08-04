<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Contracts\ProjectService;
use Modules\Project\Emails\EndedProjectMail;

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
        $service = app(ProjectService::class);
        $projectsData = $service->getMailDetailsForProjectKeyAccountManagers();
        foreach ($projectsData as $projectData) {
            Mail::queue(new EndedProjectMail($projectData));
        }
    }
}
 