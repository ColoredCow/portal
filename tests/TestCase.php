<?php

namespace Tests;

use Modules\User\Entities\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($role = null)
    {
        $user = create(User::class);
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
