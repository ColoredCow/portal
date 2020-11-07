<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

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

    protected static function setupModule($moduleName)
    {
        @shell_exec('git submodule update --init Modules/' . $moduleName);
        @shell_exec('cd Modules && cd ' . $moduleName . ' && composer install && npm install && npm run dev');
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
            $moduleList = Module::allEnabled();
            foreach ($moduleList as $module) {
                self::setupModule($module->getName());
            }
        } else {
            Module::has($moduleName) ? self::setupModule($moduleName) : $this->info('Module ' . $moduleName . ' does not exist');
        }
    }
}
