<?php

namespace Modules\Report\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ReportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Permission::updateOrCreate(['name' => 'finance_reports.view']);
        Permission::updateOrCreate(['name' => 'report.view']);
        Permission::updateOrCreate(['name' => 'report.edit']);

        $this->call(ReportRoleHasPermissionTableSeeder::class);
    }
}
