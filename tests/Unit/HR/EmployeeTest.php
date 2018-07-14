<?php

namespace Tests\Unit\HR;

use App\Models\HR\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected $employee;

    public function setUp()
    {
        parent::setUp();
        $this->employee = create(Employee::class);
    }

    /** @test */
    public function it_is_created()
    {
        $this->assertTrue(isset($this->employee->id));
    }
}
