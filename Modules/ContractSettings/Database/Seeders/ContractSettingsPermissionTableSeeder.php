<?php

namespace Modules\ContractSettings\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ContractSettingsPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $contractSettingPermissions = [
            ['name' => 'contractsettings.view'],
        ];
        foreach ($contractSettingPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
