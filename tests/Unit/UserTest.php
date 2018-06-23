<?php

namespace Tests\Unit;

use App\Models\HR\Employee;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

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
