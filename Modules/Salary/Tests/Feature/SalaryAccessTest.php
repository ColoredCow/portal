<?php

namespace Modules\Salary\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class SalaryAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /** @test */
    public function it_redirects_guests_to_login()
    {
        $this->get(route('salary.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function it_forbids_users_without_salary_view_permission()
    {
        Permission::create(['name' => 'employee_salary.view', 'guard_name' => 'web']);
        $this->signIn();

        $this->get(route('salary.index'))->assertForbidden();
    }

    /** @test */
    public function it_allows_users_with_salary_view_permission_to_access_the_salary_list()
    {
        $permission = Permission::create(['name' => 'employee_salary.view', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->givePermissionTo($permission);
        $this->be($user);

        $this->get(route('salary.index'))->assertSuccessful();
    }
}
