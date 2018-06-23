<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class FeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
    }

    public function anAuthorizedUser($role = 'super-admin')
    {
        $this->signIn(create(User::class)->assignRole($role));
    }
}
