<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

abstract class FeatureTest extends TestCase
{
    use RefreshDatabase;

    public function __construct()
    {
        parent::__construct();
        if(!$this->app) {
            $this->app = $this->createApplication();
        }
    
        $config = $this->app->make('config');
        $config->set('database.default', 'master_test');
        $this->connectionsToTransact = ['master_test'];
    }

    public function setUp()
    {
        parent::setUp();
        $this->setupTenant();
       //$this->setUpRolesAndPermissions();
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
        $this->artisan('db:seed');
        return $this;
    }
}
