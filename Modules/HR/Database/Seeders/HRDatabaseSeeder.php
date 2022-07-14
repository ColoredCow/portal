<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HRDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(HRPermissionsTableSeeder::class);
        $this->call(HRRoleHasPermissionsTableSeeder::class);
        $this->call(VolunteersModuleSeeder::class);
        $this->call(HRRoundsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(HRJobsSeederTableSeeder::class);
        $this->call(AddPreparatoryRoundsSeeder::class);
        $this->call(HrApplicantsTableSeeder::class);
        $this->call(HrApplicationRoundTableSeeder::class);
        $this->call(HrApplicationsTableSeeder::class);
        $this->call(HrChannelSeederTableSeeder::class);
    }
}
