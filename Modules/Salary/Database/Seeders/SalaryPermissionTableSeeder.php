<?php

namespace Modules\Salary\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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

        $employeeSalaryPermissions = [
            ['name' => 'employee_salary.create'],
            ['name' => 'employee_salary.view'],
            ['name' => 'employee_salary.update'],
            ['name' => 'employee_salary.delete'],
        ];

        $employeeSalarySettingsPermissions = [
            ['name' => 'employee_salary_settings.create'],
            ['name' => 'employee_salary_settings.view'],
            ['name' => 'employee_salary_settings.update'],
            ['name' => 'employee_salary_settings.delete'],
        ];

        $allEmployeeSalarySettings = array_merge($employeeSalaryPermissions, $employeeSalarySettingsPermissions);
        foreach ($allEmployeeSalarySettings as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($allEmployeeSalarySettings as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for finance-manager role
        $financeManagerRole = Role::where(['name' => 'finance-manager'])->first();
        foreach ($allEmployeeSalarySettings as $permission) {
            $financeManagerRole->givePermissionTo($permission);
        }
    }
}
