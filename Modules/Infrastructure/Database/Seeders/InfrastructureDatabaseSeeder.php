<?php

namespace Modules\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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

        $infrastructureBillingsPermissions = [
            ['name' => 'infrastructure.billings.create'],
            ['name' => 'infrastructure.billings.view'],
            ['name' => 'infrastructure.billings.update'],
            ['name' => 'infrastructure.billings.delete'],
        ];

        $infrastructureBackupsPermissions = [
            ['name' => 'infrastructure.backups.create'],
            ['name' => 'infrastructure.backups.view'],
            ['name' => 'infrastructure.backups.update'],
            ['name' => 'infrastructure.backups.delete'],
        ];

        $infrastructureEC2InstancesPermissions = [
            ['name' => 'infrastructure.ec2-instances.create'],
            ['name' => 'infrastructure.ec2-instances.view'],
            ['name' => 'infrastructure.ec2-instances.update'],
            ['name' => 'infrastructure.ec2-instances.delete'],
        ];

        $allInfraStructurePermissions = array_merge(
            $infrastructureBillingsPermissions,
            $infrastructureBackupsPermissions,
            $infrastructureEC2InstancesPermissions,
        );

        foreach ($allInfraStructurePermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($allInfraStructurePermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
    }
}
