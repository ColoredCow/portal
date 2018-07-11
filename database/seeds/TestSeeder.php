<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        DB::connection('master_test')->table('organizations')->truncate();
        DB::connection('master_test')->table('configurations')->truncate();

        DB::table('organizations')->insert([
            [
                'id' => 1,
                'slug' => 'coloredcow-test',
                'name' => 'ColoredCow test',
                'contact_email' => 'test@coloredcow.com'
            ],  
        ]);

        DB::table('configurations')->insert([
            [
                'id' => 1,
                'organization_id' => 1,
                'key' => 'connection',
                'value' => 'tenant_test'
            ],  

            [
                'id' => 2,
                'organization_id' => 1,
                'key' => 'database',
                'value' => 'emp_org_tenant_test'
            ], 
        ]);
    }
}
