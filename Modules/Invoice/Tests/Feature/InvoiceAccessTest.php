<?php

namespace Modules\Invoice\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class InvoiceAccessTest extends TestCase
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
        $this->get(route('invoice.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function it_forbids_users_without_the_invoice_view_permission()
    {
        Permission::create(['name' => 'finance_invoices.view', 'guard_name' => 'web']);
        $this->signIn();

        $this->get(route('invoice.index'))->assertForbidden();
    }

    /** @test */
    public function it_allows_users_with_invoice_view_permission_to_access_the_invoice_list()
    {
        $permission = Permission::create(['name' => 'finance_invoices.view', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->givePermissionTo($permission);
        $this->be($user);

        $this->get(route('invoice.index'))->assertSuccessful();
    }
}
