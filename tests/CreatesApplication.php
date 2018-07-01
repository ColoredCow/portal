<?php

namespace Tests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Console\Kernel;
use Tests\isTenantTest;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Hash::driver('bcrypt')->setRounds(4);

        $this->checkForTenantTest($app);

        return $app;
    }


    protected function checkForTenantTest($app) {
        $uses = array_flip(class_uses_recursive(static::class));

        if(isset($uses[isTenantTest::class])) {
             $this->refreshTenantDataBase($app);
        }
        
    }
}
