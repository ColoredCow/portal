<?php
namespace Modules\Lead\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $leadPermissions = [
            ['name' => 'lead.create'],
            ['name' => 'lead.view'],
            ['name' => 'lead.update'],
            ['name' => 'lead.delete'],
        ];
        foreach ($leadPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($leadPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
    }
}
