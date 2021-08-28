<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HRRoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $hrManager = Role::where(['name'=>'hr-manager'])->first();
        $hrManager->syncPermissions(Permission::where('name', 'LIKE', 'hr_%')->get());
    }
}
