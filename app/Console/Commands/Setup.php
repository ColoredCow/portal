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
        if (! app()->environment('local')) {
            return false;
        }

        Artisan::call('config:clear');
        $this->info('Resetting the database');
        Artisan::call('migrate:fresh');
        $this->info('Seeding common data');
        Artisan::call('db:seed');
        $this->info('Seeding module data');
        Artisan::call('module:seed');
        // Artisan::call('test');

        // php artisan migrate:fresh
        // php artisan run seeders
        // php artisan test
    }
}
