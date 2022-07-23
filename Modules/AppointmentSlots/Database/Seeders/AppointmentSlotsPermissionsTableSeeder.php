<?php

namespace Modules\AppointmentSlots\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class AppointmentSlotsPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('permission:cache-reset');

        $appointmentSlotsPermissions = [
            ['name' => 'employee_appointmentslots.create'],
            ['name' => 'employee_appointmentslots.view'],
            ['name' => 'employee_appointmentslots.update'],
            ['name' => 'employee_appointmentslots.delete'],
        ];
        foreach ($appointmentSlotsPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($appointmentSlotsPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for hr-manager role
        $hrManagerRole = Role::where(['name' => 'hr-manager'])->first();
        foreach ($appointmentSlotsPermissions as $permission) {
            $hrManagerRole->givePermissionTo($permission);
        }
    }
}
