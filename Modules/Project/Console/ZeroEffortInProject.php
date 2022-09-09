<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Emails\ZeroEffortInProjectMail;

class ZeroEffortInProject extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:zero-effort-in-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a list of projects to the project manager when the team member effort is zero.';

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
        $service = app(ProjectServiceContract::class);
        $keyAccountManagersDetails = $service->getMailDetailsForKeyAccountManager();
        foreach ($keyAccountManagersDetails as $keyAccountManagerDetails) {
            Mail::queue(new ZeroEffortInProjectMail($keyAccountManagerDetails));
        }
    }
}
