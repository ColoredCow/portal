<?php

namespace Tests\Feature\HR;

use App\Models\HR\Employee;
use App\User;
use Tests\Feature\FeatureTest;

class EmployeeTest extends FeatureTest
{
    /** @test */
    public function user_name_gets_updated_when_employee_name_is_updated()
    {
        $user = create(User::class);
        $employee = $user->employee;
        $newName = 'John Doe';
        $employee->update([
            'name' => $newName,
        ]);
        $this->assertTrue($employee->user->name == $newName);
    }

    /** @test */
    public function a_guest_cant_see_employee_list()
    {
        $this->get(route('employees'))->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_see_employee_list()
    {
        $this->anAuthorizedUser();
        $this->get(route('employees'))
            ->assertStatus(200);
    }
}
