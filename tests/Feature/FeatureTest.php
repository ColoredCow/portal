<?php

namespace Tests\Feature;

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

    public function signInAsSuperAdmin()
    {
        $this->signIn('super-admin');
    }
}
