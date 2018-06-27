<?php

namespace Tests;

use App\Models\Organization;


trait isTenantTest
{
  
    public function __construct()
    {
        parent::__construct();
        $this->setupDatabase();
    }

    public function setupDatabase() {
        if(!$this->app) {
            $this->app = $this->createApplication();
        }
        $this->artisan('migrate:all', ['--database' => 'master_test']);
        $config = $this->app->make('config');
        $config->set('database.default', 'tenant_test');
        $this->connectionsToTransact = ['tenant_test'];
    }
}
