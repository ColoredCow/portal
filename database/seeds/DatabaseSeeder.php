<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(VolunteersModuleSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(SalaryConfigurationsTableSeeder::class);
        $this->call(BookCategoriesTableSeeder::class);
        $this->call(HrRoundsTableSeeder::class);
        $this->call(LegalDocumentsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AddPreparatoryRoundsSeeder::class);
    }
}
