<?php

namespace Modules\AppointmentSlots\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
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
        Model::unguard();
        Permission::create(['name' => 'employee_appointmentslots.view']);
        Permission::create(['name' => 'employee_appointmentslots.create']);
        Permission::create(['name' => 'employee_appointmentslots.update']);
        Permission::create(['name' => 'employee_appointmentslots.delete']);
    }
}
