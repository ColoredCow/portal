<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserLogInTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->userLogInFailedWithWrongPassword();
        $this->userLogIn();
    }
}
