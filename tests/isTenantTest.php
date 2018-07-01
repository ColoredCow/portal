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
        $this->connectionsToTransact = ['tenant_test'];
    }
}
