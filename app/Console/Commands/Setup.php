<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean and Setup the system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! app()->environment(['local', 'staging', 'UAT'])) {
            return 0;
        }

        Artisan::call('config:clear');
        $this->info('Resetting the database');
        Artisan::call('migrate:fresh');
        $this->info('Seeding data');
        Artisan::call('db:seed');
        Artisan::call('module:seed');
        $this->info('Setup completed.');

        return 1;
    }
}
