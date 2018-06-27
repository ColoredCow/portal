<?php

namespace App\Console\Commands;

use App\Models\Configuration;
use Illuminate\Console\Command;

class MigrateAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:all {--database=master}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->call('migrate', array('--database' => $this->option('database'), '--path' => 'database/migrations/master/'));
        $tenants = Configuration::where('key', 'database');
        foreach ($tenants as $tenant) {
            $this->call('migrate', array('--database' => $tenant['value'], '--path' => 'database/migrations/'));
        }
    }
}
