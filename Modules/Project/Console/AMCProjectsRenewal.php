<?php

namespace Modules\Project\Console;

use Modules\Client\Entities\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Emails\AMCProjectRenewalMail;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;
use Mpdf\Tag\Select;

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
        $keyaccountmanagers = client::pluck('key_account_manager_id');
        dd($keyaccountmanagers);
      foreach($keyaccountmanagers as $keyaccountmanager){
        $user = User::select('*')->where('id', $keyaccountmanager)->get();
        dd($user);
      }

        $projects = Project::where('is_amc', '1')->where('status', 'active')->get();
        
        foreach ($projects as $project) {
            
        
            // dd($data);

            if ($project->is_ready_to_renew) {
                $diff = optional($project->end_date)->diffInDays(today());

                // dd($project->name);
                // dd($diff);
                if ($diff == 0 || $diff == 7 || $diff == 15 || $diff == 30) {
                    return Mail::queue(new AMCProjectRenewalMail($project));
                }
            }
        }
    }
}


