<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Tests\isTenantTest;

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
