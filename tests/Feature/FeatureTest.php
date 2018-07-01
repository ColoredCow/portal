<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Tests\isTenantTest;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

abstract class FeatureTest extends TestCase
{
    use RefreshDatabase, isTenantTest;

    public function setUp()
    {
        parent::setUp();
        $this->setupTenantDatabase();
        $this->setUpRolesAndPermissions();
    }

    public function signInAsSuperAdmin()
    {
        $this->signIn(create(User::class)->assignRole('super-admin'));
    }

}
