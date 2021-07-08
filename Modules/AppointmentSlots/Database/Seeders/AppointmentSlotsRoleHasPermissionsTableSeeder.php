<?php

namespace Modules\AppointmentSlots\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppointmentSlotsRoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $admin = Role::where(['name' => 'admin'])->first();
        $admin->syncPermissions(Permission::whereIn('name', [
            'employee_appointmentslots.view',
            'employee_appointmentslots.create',
            'employee_appointmentslots.update',
            'employee_appointmentslots.delete',
        ])->get());
    }
}
