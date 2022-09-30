<?php

namespace Modules\ProjectContract\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\ProjectContract\Entities\ProjectContractMeta;

class ProjectContractDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ProjectContractPermissionsTableSeeder::class);
    }
}
