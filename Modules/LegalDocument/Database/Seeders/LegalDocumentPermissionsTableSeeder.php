<?php

namespace Modules\LegalDocument\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class LegalDocumentPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $ndaSettingsPermissions = [
            ['name' => 'nda_settings.create'],
            ['name' => 'nda_settings.view'],
            ['name' => 'nda_settings.update'],
            ['name' => 'nda_settings.delete'],
        ];
        foreach ($ndaSettingsPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($ndaSettingsPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for finance-manager role
        $financeManagerRole = Role::where(['name' => 'finance-manager'])->first();
        foreach ($ndaSettingsPermissions as $permission) {
            $financeManagerRole->givePermissionTo($permission);
        }
    }
}
