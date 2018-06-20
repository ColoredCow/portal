<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');
        $this->be($user);
        return $this;
    }

    protected function setUpRolesAndPermissions()
    {
        $this->artisan('db:seed');
        return $this;
    }
}
