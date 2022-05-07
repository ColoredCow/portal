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

        Permission::updateOrCreate(['name' => 'employee_appointmentslots.view']);
        Permission::updateOrCreate(['name' => 'employee_appointmentslots.create']);
        Permission::updateOrCreate(['name' => 'employee_appointmentslots.update']);
        Permission::updateOrCreate(['name' => 'employee_appointmentslots.delete']);
    }
}
