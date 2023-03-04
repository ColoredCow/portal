<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ResumeScreeningPendingApplication;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\Application;

class ManageApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:resume-screening-application-review-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will trigger mail to HR reminding him to review applications that are in resume screening round for more than 3 days';

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
        $now = now();

        $threeDaysAgo = $now->subDays(3);

        $applications = Application::with('applicant')
                      ->where('status', config('hr.status.new'))
                      ->where('hr_applications.created_at', '<', $threeDaysAgo)
                      ->get();

        $applicantDetails = [];

        foreach ($applications as $application) {
            $applicantDetails[] = [
                "name" => $application->applicant->name,
                "phone" => $application->applicant->phone,
                "id" => $application->applicant->id,
                "email" => $application->applicant->email
            ];
        }

        if ($applications->count() > 0) {
            Mail::to(config('hr.hr-email.primary'))->send(new ResumeScreeningPendingApplication($applications));

            $this->info('Email sent successfully!');
        } else {
            $this->info('No applicants found!');
        }

        return 0;
    }
}
