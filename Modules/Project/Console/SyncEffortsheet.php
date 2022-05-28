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
    protected $description = 'This commands syncs the effortsheets with the projects';

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
        $projects = Project::where('status', 'active')->get();

        foreach ($projects as $project) {
            $effortTracking =  new EffortTrackingService;
            $effortTracking->refreshEfforts($project);
        }
    }
}
