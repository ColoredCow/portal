<?php
namespace Modules\HR\Console\Recruitment;

use Illuminate\Console\Command;
use Modules\HR\Entities\Application;
use Symfony\Component\Console\Input\InputOption;

class ResetIsLatestApplicationRound extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:reset-application-round-latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset application round is latest fields for all the applications';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applications = Application::cursor()->filter(function ($application) {
            return $application->id > 0 && $application->id < 500;
        });

        foreach ($applications as $application) {
            $latestRound = $application->latestApplicationRound;
            $latestRound->updateIsLatestColumn();
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
