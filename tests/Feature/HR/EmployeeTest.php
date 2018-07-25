<?php

namespace Tests\Feature\HR;

use App\Models\HR\Employee;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\Feature\FeatureTest;

class EmployeeTest extends FeatureTest
{
    /** @test */
    public function guest_cant_see_employee_list()
    {
        $this->withoutExceptionHandling()->expectException(AuthenticationException::class);
        $this->get(route('employees'));
    }

    /** @test */
    public function superadmin_can_see_employee_list()
    {
        $this->signInAsSuperAdmin();
        $this->get(route('employees'))
            ->assertStatus(200);
    }

    /** @test */
    public function user_name_is_synced_with_employee_name()
    {
        $user = create(User::class);
        $employee = $user->employee;
        $newName = 'John Doe';
        $employee->update([
            'name' => $newName,
        ]);
        $this->assertEquals($employee->user->name, $newName);
    }
}
