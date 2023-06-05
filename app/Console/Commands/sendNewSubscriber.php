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
    protected $signature = 'migrate_applicants_to_email_campaign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command send applicient data to the Campaigns to create new subscriber';

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

        foreach ($applicants as $applicant) {
            $name = $applicant->name;
            $nameParts = explode(' ', $name, 2);

            $data = [
                'first_name' =>   $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'email' => $applicant->email,
                'phone' => $applicant->phone,
            ];

            $jobIds = Application::where('hr_applicant_id', $applicant->id)->pluck('hr_job_id')->toArray();

            if (!empty($jobIds)) {
                $subscriptionLists = [];
                foreach ($jobIds as $jobId) {
                    $subscriptionList = Job::where('id', $jobId)->value('title');
                    $subscriptionLists[] = $subscriptionList;
                }
                if ($subscriptionLists) {
                    try {
                        $applicationService = new ApplicationService();
                        $applicationService->addSubscriberToCampaigns($data, $subscriptionLists);
                    } catch (\Exception $e) {
                        $this->error('Error occurred while sending data to Campaign');
                    }
                }
            }
        }

        return 0;
    }
}
