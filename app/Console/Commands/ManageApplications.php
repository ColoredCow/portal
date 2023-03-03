<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\ResumeScreeningPendingApplication;
use Illuminate\Support\Facades\Mail;

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

        $screeningApplicants = DB::table('hr_applicants')
                    ->join('hr_applications', 'hr_applicants.id', '=', 'hr_applications.hr_applicant_id')
                    ->select('hr_applicants.id', 'hr_applicants.name', 'hr_applicants.email', 'hr_applicants.phone', 'hr_applications.status', 'hr_applications.created_at')
                    ->where('hr_applications.status', config('hr.status.new'))
                    ->where('hr_applications.created_at', '<', $threeDaysAgo)
                    ->get();

        if ($screeningApplicants->count() > 0) {
            Mail::to(config('hr.hr-email.primary'))->send(new ResumeScreeningPendingApplication($screeningApplicants));

            $this->info('Email sent successfully!');
        } else {
            $this->info('No applicants found!');
        }

        return 0;
    }
}
