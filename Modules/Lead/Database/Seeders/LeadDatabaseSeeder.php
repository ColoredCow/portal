<?php

namespace Modules\Lead\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class LeadDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Permission::updateOrCreate(['name' => 'lead.create']);
        Permission::updateOrCreate(['name' => 'lead.view']);
        Permission::updateOrCreate(['name' => 'lead.update']);
        Permission::updateOrCreate(['name' => 'lead.delete']);
    }
}
