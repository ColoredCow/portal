<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clients')->delete();

        \DB::table('clients')->insert([
            0 => [
                'id' => 1,
                'name' => 'Rahul',
                'status' => 'Not Active',
                'key_account_manager_id' => null,
                'created_at' => null,
                'updated_at' => null,
                'is_channel_partner' => '0',
                'has_departments' => '0',
                'channel_partner_id' => null,
                'parent_organisation_id' => null,
                'country' => 'India',
                'state' => null,
                'phone' => null,
                'address' => null,
                'pincode' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'Raj',
                'status' => 'Not Active',
                'key_account_manager_id' => null,
                'created_at' => null,
                'updated_at' => null,
                'is_channel_partner' => '0',
                'has_departments' => '0',
                'channel_partner_id' => null,
                'parent_organisation_id' => null,
                'country' => 'India',
                'state' => null,
                'phone' => null,
                'address' => null,
                'pincode' => null,
            ],
        ]);
    }
}
