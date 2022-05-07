<?php

namespace Modules\Client\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Client\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ClientDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Permission::updateOrCreate(['name' => 'clients.create']);
        Permission::updateOrCreate(['name' => 'clients.view']);
        Permission::updateOrCreate(['name' => 'clients.update']);
        Permission::updateOrCreate(['name' => 'clients.delete']);

        // seed fake data
        if (! app()->environment('production')) {
            Client::factory()->count(3)->create();
        }
    }
}
