<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($role = 'employee')
    {
        $user = create(User::class);
        $user->assignRole($role);
        $this->be($user);
        return $this;
    }

    protected function setUpRolesAndPermissions()
    {
        $this->artisan('db:seed');
        return $this;
    }
}
