<?php

namespace Modules\Operation\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Operation\Database\Seeders\SeedFakeOfficeLocationsTableSeeder;

class OperationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(SeedFakeOfficeLocationsTableSeeder::class);
    }
}
