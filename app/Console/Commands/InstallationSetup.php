<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallationSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:setup {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Intsall the specified submodule';

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
        $moduleName = $this->option('module');
        if (!$moduleName) {
            $shellOutput=@shell_exec('npm install && npm run dev');
            $this->info($shellOutput);
        } else {
            $shellOutput=@shell_exec('git submodule update --init Modules/'.$moduleName);
            $this->info($shellOutput);
            $shellOutput=@shell_exec('cd Modules && cd '.$moduleName.' && composer install && npm install && npm run dev');
            $this->info($shellOutput);
        }
    }
}
