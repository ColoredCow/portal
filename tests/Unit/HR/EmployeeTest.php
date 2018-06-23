<?php

namespace Tests\Unit\HR;

use App\Models\HR\Employee;
use App\User;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /** @test */
    public function an_employee_is_created()
    {
        $employee = create(Employee::class);
        $this->assertTrue(isset($employee->id));
    }

    /** @test */
    public function employee_gets_created_for_a_new_user()
    {
        $user = create(User::class);
        $this->assertTrue(isset($user->employee, $user->employee->id));
        $this->assertTrue($user->name == $user->employee->name);
    }
}
