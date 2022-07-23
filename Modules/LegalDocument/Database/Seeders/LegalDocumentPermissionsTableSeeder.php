<?php

namespace Modules\LegalDocument\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class LegalDocumentPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Permission::updateOrCreate(['name' => 'nda_settings.create']);
        Permission::updateOrCreate(['name' => 'nda_settings.view']);
        Permission::updateOrCreate(['name' => 'nda_settings.update']);
        Permission::updateOrCreate(['name' => 'nda_settings.delete']);
    }
}
