<?php

namespace Modules\AppointmentSlots\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AppointmentSlotsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(AppointmentSlotsPermissionsTableSeeder::class);
    }
}
