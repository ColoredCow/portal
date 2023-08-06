<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:ci 
    {--with-tty : Disable output to TTY}
    {--c|cypress : Include cypress test as well}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Single command to check all CI checks';

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

        return 0;
    }

    private function checkCommand($command, $name)
    {
        $this->line("Running {$name}");

        $process = new Process($command);

        try {
            $process
            ->setTimeout(60 * 7)
            ->mustRun(function ($type, $line) {
                if ($type && $this->option('with-tty')) {
                    $this->output->write($line);
                }
            });
            $this->info("{$name} Completed.");
        } catch (ProcessFailedException $e) {
            $this->error("{$name} Failed.");
            $this->line($e->getMessage());
            $this->commandSeparator();
            exit(1);
        }

        $this->commandSeparator();
    }

    private function commandSeparator()
    {
        $this->info('---------------------------------------------------------------------------------------');
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
        $phpInsights = ['php', 'artisan', 'insights', '-v', '--no-interaction'];

        $ciCommands = [];
        // $ciCommands['Php CS Fixer'] = $staticAnalysis;
        // $ciCommands['LaraStan'] = $laraStan;
        // $ciCommands = array_merge($ciCommands, $this->getEsCommands());
        $ciCommands['Insights'] = $phpInsights;

        return $ciCommands;
    }

    private function getEsCommands()
    {
        // Modules/*/Resources/assets/js/  wild card does not work with Process so
        // we had to expend the files based on modules
        $moduleNames = collect(array_keys(Module::all()));
        $moduleJsFiles = $moduleNames->map(function ($moduleName) {
            return "Modules/{$moduleName}/Resources/assets/js/";
        })->toArray();

        $esCheckCommand = array_merge(['./node_modules/.bin/eslint', 'resources/js/'], $moduleJsFiles, ['--ext', '.js,.vue']);

        return [
        'ESLint fix' => array_merge($esCheckCommand, ['--fix']),
        'ESLint check' => $esCheckCommand
        ];
    }
}
