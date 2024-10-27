<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('countries')->delete();

        \DB::table('countries')->insert([
            0 => [
                'id' => 1,
                'name' => 'India',
                'initials' => 'IN',
                'currency' => 'INR',
                'currency_symbol' => '₹',
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'United States',
                'initials' => 'US',
                'currency' => 'USD',
                'currency_symbol' => '$',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
