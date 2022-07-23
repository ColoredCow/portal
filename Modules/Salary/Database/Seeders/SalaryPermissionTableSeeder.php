<?php

namespace Modules\Salary\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class SalaryPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $roles = ['employee_salary.create', 'employee_salary.view', 'employee_salary.update', 'employee_salary.delete'];
        foreach ($roles as $role) {
            Permission::updateOrCreate(['name' => $role]);
        }
    }
}
