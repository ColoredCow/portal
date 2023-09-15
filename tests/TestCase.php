<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\User\Entities\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($role = null)
    {
        $user = User::factory()->create();
        is_null($role) ?: $user->assignRole($role);
        $this->be($user);

        return $this;
    }

    protected function setUpRolesAndPermissions()
    {
        $this->artisan('db:seed');

        return $this;
    }
}
