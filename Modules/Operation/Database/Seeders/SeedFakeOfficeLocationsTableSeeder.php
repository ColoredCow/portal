<?php

namespace Modules\Operation\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Operation\Entities\OfficeLocation as OfficeLocation;

class SeedFakeOfficeLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $locations = ['Gurugram', 'Tehri', 'Ranchi'];
        foreach ($locations as $location) {
            $officeLocation = new OfficeLocation;
            $officeLocation->location = $location;
            $officeLocation->save();
        }
    }
}
