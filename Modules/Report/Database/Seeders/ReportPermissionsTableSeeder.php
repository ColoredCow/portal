<?php

namespace Modules\Report\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ReportPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Permission::create(['name' => 'report.view']);
        Permission::create(['name' => 'report.edit']);
    }
}
