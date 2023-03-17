<?php

namespace Modules\Project\Console;

use App\Traits\HasTags;
use Illuminate\Console\Command;
use Modules\Project\Entities\Project;

class CheckProjectRenewalTag extends Command
{
    use HasTags;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:renewal-tag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if projects are ready to renew';

    public function handle()
    {
        $projects = Project::where('is_amc', '1')->where('status', 'active')->get();

        foreach ($projects as $project) {
            $project->is_ready_to_renew ? $project->tag('get-renewed') : $project->untag('get-renewed');
        }
    }
}
