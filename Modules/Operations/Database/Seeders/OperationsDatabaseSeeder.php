<?php
namespace Modules\Operations\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class OperationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(OfficeLocationTableSeeder::class);
        $this->call(OperationsPermissionTableSeeder::class);
    }
}
