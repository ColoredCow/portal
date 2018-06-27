<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Tests\isTenantTest;
use App\Models\Organization;

abstract class FeatureTest extends TestCase
{
    use RefreshDatabase, isTenantTest;

    public function setUp()
    {
        parent::setUp();
        session(['active_master_connection' => 'master_test']);
        //$organization = factory(Organization::class)->create();

        
        //$this->setupTenant();
       // $this->setUpRolesAndPermissions();
    }

    public function signInAsSuperAdmin()
    {
        $this->signIn(create(User::class)->assignRole('super-admin'));
    }

    public function setupTenant() {
        $config = $this->app->make('config');
        $config->set('database.default', 'master_test');
        $this->connectionsToTransact = ['master_test'];
        session()->put('active_connection', 'master_test');
        return $this;
    }






}
