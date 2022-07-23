<?php

namespace Modules\Prospect\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ProspectDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Permission::updateOrCreate(['name' => 'prospect.create']);
        Permission::updateOrCreate(['name' => 'prospect.view']);
        Permission::updateOrCreate(['name' => 'prospect.update']);
        Permission::updateOrCreate(['name' => 'prospect.delete']);
    }
}
