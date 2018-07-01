<?php

namespace Tests;

use App\Models\Organization;
use Illuminate\Contracts\Console\Kernel;


trait isTenantTest
{
  
    public static $tenantMigrated = false;

    public function __construct()
    {
        parent::__construct();
        $this->connectionsToTransact = ['tenant_test'];
    }

    public function setupTenantDatabase() {
        $organization = Organization::first();
        \Tenant::setUpForDomain($organization->slug);
    }

    public function refreshTenantDataBase($app) {
        if(!self::$tenantMigrated) {
            $app[Kernel::class]->call('migrate:fresh', ['--database' => 'tenant_test']);
            self::$tenantMigrated = true;
        }
    }
}
