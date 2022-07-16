<?php

namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\HR\Entities\Application;
use Modules\HR\Jobs\Recruitment\SendEmailToNonVerifiedApplicants;

class DailyMessage extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:message-for-email-verified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to non verified applicants.';

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
        dd("hello");
        $applications = Application::select('*')->where('is_verified', false)->where('created_at', '>=', '2022-07-06')->get();
        foreach($applications as $application)
        {
            SendEmailToNonVerifiedApplicants::dispatch($application);
        }

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
