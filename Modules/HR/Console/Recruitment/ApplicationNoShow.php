<?php

namespace Modules\HR\Console\Recruitment;

use App\Models\Setting;
use Illuminate\Console\Command;
use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Entities\ApplicationRound;

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
     public $description = 'Set application status to no-show if an application round is not conducted 2 hours after scheduled time';

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
        $applicationRounds = ApplicationRound::with('application', 'application.applicant')
            ->whereHas('application', function ($query) {
                $query->whereIn('status', [
                    config('constants.hr.status.new.label'),
                    config('constants.hr.status.in-progress.label'),
                ]);
            })
            ->whereHas('round', function ($query) {
                $query->where('reminder_enabled', true);
            })
            ->whereNull('round_status')
            ->whereDate('scheduled_date', '=', today()->toDateString())
            ->where('scheduled_date', '<=', now()->subHours(config('constants.hr.no-show-hours-limit'))->toDateTimeString())
            ->get();

        $subject = Setting::module('hr')->key('no_show_mail_subject')->first();
        $subject = $subject ? $subject->setting_value : null;
        $body = Setting::module('hr')->key('no_show_mail_body')->first();
        $body = $body ? $body->setting_value : null;

        if ($subject && $body) {
            foreach ($applicationRounds as $applicationRound) {
                $application = $applicationRound->application;
                $job = $application->job;

                $body = str_replace(config('constants.hr.template-variables.applicant-name'), $application->applicant->name, $body);
                $body = str_replace(config('constants.hr.template-variables.interview-time'), $applicationRound->scheduled_date->format(config('constants.hr.interview-time-format')), $body);
                $body = str_replace(config('constants.hr.template-variables.job-title'), "<a href='{$job->link}'>{$job->title}</a>", $body);

                if ($application->status != config('constants.hr.application-meta.keys.no-show')) {
                    $application->markNoShowReminded();
                    ApplicationMeta::create([
                        'hr_application_id' => $application->id,
                        'key' => config('constants.hr.status.no-show.label'),
                        'value' => json_encode([
                            'round' => $applicationRound->id,
                            'mail_subject' => $subject,
                            'mail_body' => $body,
                        ]),
                    ]);
                }
            }
        }
    }
}
