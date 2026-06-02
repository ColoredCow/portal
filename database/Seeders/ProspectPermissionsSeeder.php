<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProspectPermissionsSeeder extends Seeder
{
    /**
     * Seed the Prospect module permissions.
     *
     * These permissions gate prospect access. The os-platform MCP service checks
     * them (via the Spatie model) before exposing prospect read/write tools to a
     * user, and they are available for the portal's own gating. Roles are assigned
     * through the role-management UI; `admin` is granted here as a sensible default,
     * and `super-admin` bypasses all permission checks (see AuthServiceProvider).
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('permission:cache-reset');

        $prospectPermissions = [
            ['name' => 'prospect.view'],
            ['name' => 'prospect.create'],
            ['name' => 'prospect.update'],
        ];

        foreach ($prospectPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // Grant to admin as a sensible default. Assign to any other role
        // (e.g. employee, or a future sales role) via the role-management UI.
        $adminRole = Role::where(['name' => 'admin'])->first();
        if ($adminRole) {
            foreach ($prospectPermissions as $permission) {
                $adminRole->givePermissionTo($permission['name']);
            }
        }
    }
}
