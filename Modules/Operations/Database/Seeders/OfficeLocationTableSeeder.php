<?php

namespace Modules\operations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Modules\Operations\Entities\OfficeLocation;

class OfficeLocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('constants.office_locations') as $office => $location) {
            OfficeLocation::firstOrCreate(['centre_name' => $location], [
                'centre_name' => $location,
                'centre_head_id' => User::factory()->create()->id,
                'capacity' => 50,
                'current_people_count' => 48,
            ]);
        }
    }
}
