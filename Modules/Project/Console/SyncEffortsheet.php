<?php
namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Modules\EffortTracking\Services\EffortTrackingService;
use Modules\Project\Entities\Project;

class SyncEffortsheet extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sync:effortsheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands syncs the EffortSheets with the projects';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projects = Project::where('status', 'active')->get();

        foreach ($projects as $project) {
            $effortTracking = new EffortTrackingService;
            $effortTracking->getEffortForProject($project);
        }
    }
}
