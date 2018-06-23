<?php

namespace Tests\Unit;

use App\Models\HR\Employee;
use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = create(User::class);
    }

    /** @test */
    public function it_has_an_employee()
    {
        $this->assertInstanceOf(Employee::class, $this->user->employee);
    }
}
