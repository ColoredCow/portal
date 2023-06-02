<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;
use Modules\HR\Services\ApplicationService;

class sendNewSubscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendNewSubscriber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $applicants = Applicant::select('name', 'email', 'phone', 'id')->get();

        $count = 0;   // this code is for testing need to delete after approval
        foreach ($applicants as $applicant) {
            $count = $count + 1;    // this code is for testing need to delete after approval
            $name = $applicant->name;
            $id = $applicant->id;
            $nameParts = explode(' ', trim($name));

            $data = [
                'first_name' =>   $nameParts[0],
                'last_name' =>  $nameParts[1],
                'email' => $applicant->email,
                'phone' => $applicant->phone,
            ];
    
            $jobId = Application::where('hr_applicant_id', $id)->pluck('hr_job_id');
            if ($jobId->isNotEmpty()) {
                $list = Job::where('id', $jobId)->pluck('title');
                $subscriptionLists = $list[0];
                if ($list->isNotEmpty()) {
                    try {
                        $applicationService = new ApplicationService();
                        $applicationService->addSubscriberToCampaigns($data, $subscriptionLists);
                    } catch (\Exception $e) {
                        $this->error('Error occurred while sending data to Campaign');
                    }
                }
            }
            // this code is for testing need to delete after approval
            if ($count == 3) {
                dd('stop for each loop on count = 3');
            }
        }

        return 0;
    }
}
