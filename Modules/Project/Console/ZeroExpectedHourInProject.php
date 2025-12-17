<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Emails\ZeroExpectedHourInProjectMail;
use Modules\Project\Services\ProjectService;

class ZeroExpectedHourInProject extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:zero-expected-hours-in-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send projects to the project team member when the project expected efforts are zero.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = app(ProjectService::class);
        $projectDetails = $service->getMailDetailsForZeroExpectedHours();
        foreach ($projectDetails as $projectDetail) {
            Mail::queue(new ZeroExpectedHourInProjectMail($projectDetail));
        }
    }
}
