<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Single command to check all CI checks';

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
        foreach ($this->getCommands() as $name => $command) {
            $this->checkCommand($command, $name);
        }

        return 1;
    }

    private function checkCommand($command, $name)
    {
        $this->info("Running $name");

        $process = new Process($command);

        $process->run(function ($type, $line) {
            $this->output->write($line);
        });

        if (! $process->isSuccessful()) {
            $this->info("$name Failed.");
            throw new ProcessFailedException($process);
        }

        $this->info("$name Completed.");
        $this->info('---------------------------------------------------------------------------------------');

        return 1;
    }

    private function getCommands()
    {
        $staticAnalysis = [
            'php',
            './vendor/bin/php-cs-fixer',
            'fix',
            '--config',
            '.php-cs-fixer.php',
            '--dry-run',
            '--verbose',
            '--diff',
        ];

        $laraStan = ['./vendor/bin/phpstan', 'analyse'];
        $esLintFix = ['./node_modules/.bin/eslint', 'resources/js/',  '--ext', '.js,.vue', '--fix'];
        $esLintCheck = ['./node_modules/.bin/eslint', 'resources/js/', '--ext', '.js,.vue'];

        return [
            'Php CS Fixer' => $staticAnalysis,
            'laraStan' => $laraStan,
            'Eslint fix' => $esLintFix,
            'Eslint check' => $esLintCheck
        ];
    }
}
