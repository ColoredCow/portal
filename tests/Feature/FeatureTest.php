<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

abstract class FeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
    }

    public function signInAsSuperAdmin()
    {
        $this->signIn(create(User::class)->assignRole('super-admin'));
    }


}
