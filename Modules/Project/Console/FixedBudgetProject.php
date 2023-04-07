<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Services\ProjectService;
use Modules\Project\Emails\FixedBudgetProjectMail;

class FixedBudgetProject extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:fixed-budget-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to the project key account manager when the end date of a fixed budget project is nearing.';

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
        $projectsData = $service->getMailForFixedBudgetProjectKeyAccountManagers();
        foreach ($projectsData as $projectData) {
            Mail::queue(new FixedBudgetProjectMail($projectData));
        }
    }
}
