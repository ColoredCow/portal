<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\ApplicantsSubmittedBeforeSevenDays;
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

        // Calculate the date/time 7 days ago
        $sevenDaysAgo = $now->subDays(7);

        // Get all applicants whose application was submitted before 7 days
        $applicants = DB::table('hr_applicants')
                    ->where('created_at', '<', $sevenDaysAgo)
                    ->get();

        // Check if there are any applicants
        if ($applicants->count() > 0) {
            // Send email to HR with applicant details
            Mail::to('vivek.kumar@coloredcow.in')->send(new ApplicantsSubmittedBeforeSevenDays($applicants));

            $this->info('Email sent successfully!');
        } else {
            $this->info('No applicants found!');
        }

        return 0;
    }
}
