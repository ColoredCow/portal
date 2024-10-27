<?php
namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProjectPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $projectsPermissions = [
            ['name' => 'projects.create'],
            ['name' => 'projects.view'],
            ['name' => 'projects.update'],
            ['name' => 'projects.delete'],
        ];
        foreach ($projectsPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($projectsPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for employee role
        $employeeProjectPermissions = [
            ['name' => 'projects.view'],
        ];
        $employeeRole = Role::where(['name' => 'employee'])->first();
        foreach ($employeeProjectPermissions as $permission) {
            $employeeRole->givePermissionTo($permission);
        }
    }
}
