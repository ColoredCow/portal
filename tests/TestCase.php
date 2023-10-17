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

    protected function userLogIn()
    {
        $password = 'admin';
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@abc.com',
            'password' => bcrypt($password)
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    protected function userLogInFailedWithWrongPassword()
    {
        $password = 'admin';
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@abc.com',
            'password' => bcrypt($password)
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
