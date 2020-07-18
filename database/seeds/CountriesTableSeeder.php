<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'India',
                'initials' => 'IN',
                'currency' => 'INR',
                'currency_symbol' => '₹',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'United States',
                'initials' => 'US',
                'currency' => 'USD',
                'currency_symbol' => '$',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}