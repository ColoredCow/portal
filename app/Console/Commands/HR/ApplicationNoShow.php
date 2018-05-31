<?php

namespace App\Console\Commands\HR;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\HR\ApplicationRound;
use App\Models\HR\ApplicationMeta;

class ApplicationNoShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:no-show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set application status to no-show if an application round is not conducted 2 hours after scheduled time';

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
        $applicationRounds = ApplicationRound::with('application')
                            ->whereNull('round_status')
                            ->where('scheduled_date', '<=', Carbon::now()->subHours(config('constants.hr.no-show-hours-limit'))->toDateTimeString())
                            ->get();

        foreach ($applicationRounds as $applicationRound) {
            $application = $applicationRound->application;
            if ($application->status != 'no-show') {
                $application->update([
                    'status' => 'no-show'
                ]);
                $roundNotConductedMeta = ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => config('constants.hr.application-meta.keys.no-show'),
                    'value' => json_encode([
                        'round' => $applicationRound->id,
                    ]),
                ]);
            }
        }
    }
}
