<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\ApplicantsSubmittedBeforeThreeDays;
use Illuminate\Support\Facades\Mail;

class ManageApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:send-mail-to-hr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check every morning';

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
        // Get the current date/time
        $now = now();

        // Calculate the date/time 3 days ago
        $threeDaysAgo = $now->subDays(3);

        // Get all applicants whose application was submitted before 3 days
        $screeningApplicants = DB::table('hr_applicants')
                    ->join('hr_applications', 'hr_applicants.id', '=', 'hr_applications.hr_applicant_id')
                    ->select('hr_applicants.id', 'hr_applicants.name', 'hr_applicants.email', 'hr_applicants.phone', 'hr_applications.status')
                    ->where('hr_applications.status', config('hr.status.new.label'))
                    ->where('hr_applications.created_at', '<', $threeDaysAgo)
                    ->get();

        // Check if there are any applicants
        if ($screeningApplicants->count() > 0) {
            // Send email to HR with applicant details
            Mail::to('vivek.kumar@coloredcow.in')->send(new ApplicantsSubmittedBeforeThreeDays($screeningApplicants));

            $this->info('Email sent successfully!');
        } else {
            $this->info('No applicants found!');
        }

        return 0;
    }
}
