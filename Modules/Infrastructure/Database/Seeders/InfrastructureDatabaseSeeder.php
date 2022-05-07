<?php

namespace Modules\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class InfrastructureDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Permission::updateOrCreate(['name' => 'infrastructure.billings.create']);
        Permission::updateOrCreate(['name' => 'infrastructure.billings.view']);
        Permission::updateOrCreate(['name' => 'infrastructure.billings.update']);
        Permission::updateOrCreate(['name' => 'infrastructure.billings.delete']);

        Permission::updateOrCreate(['name' => 'infrastructure.backups.create']);
        Permission::updateOrCreate(['name' => 'infrastructure.backups.view']);
        Permission::updateOrCreate(['name' => 'infrastructure.backups.update']);
        Permission::updateOrCreate(['name' => 'infrastructure.backups.delete']);

        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.create']);
        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.view']);
        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.update']);
        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.delete']);
    }
}
