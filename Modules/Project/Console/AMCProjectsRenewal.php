<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Client\Entities\Client;
use Modules\Project\Emails\AMCProjectRenewalMail;
use Modules\User\Entities\User;

class AMCProjectsRenewal extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:handle-amc-renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail when Project Get Renewed Tag';

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
        $keyAccountManagersId = Client::pluck('key_account_manager_id')->unique();
        foreach ($keyAccountManagersId as $keyAccountManager) {
            $clients = Client::where('key_account_manager_id', $keyAccountManager)->get();
            $projectAmcRenewal = [];
            $keyAccountManagerEmail = User::select('email')->where('id', $keyAccountManager)->get();
            foreach ($clients as $client) {
                $projects = $client->projects()
                    ->where('is_amc', '1')
                    ->where('status', 'active')
                    ->get();
                foreach ($projects as $project) {
                    $diff = $project->getAmcDateDiffAttribute($project);
                    if ($diff <= 0 || $diff == 7 || $diff == 15 || $diff == 30) {
                        $projectAmcRenewal[] = $project;
                        $keyAccountManagerEligibleProject = $projectAmcRenewal;
                    }
                }
            }
            if (! empty($keyAccountManagerEligibleProject)) {
                return Mail::queue(new AMCProjectRenewalMail($keyAccountManagerEligibleProject, $keyAccountManagerEmail));
            }
        }
    }
}
