<?php
namespace Modules\CodeTrek\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CodeTrekDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CodeTrekPermissionTableSeeder::class);
        $this->call(CodeTrekApplicantRoundDetailsTableSeeder::class);
    }
}
