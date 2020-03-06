<?php

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


$states = [ 
    ['name' => 'Andaman', 'gst_code' => '35',],
    ['name' => 'Arunachal Pradesh', 'gst_code' =>'12',],
    ['name' => 'Assam', 'gst_code' =>'18',],
    ['name' => 'Bihar', 'gst_code' =>'10',],
    ['name' =>'Chhattisgarh', 'gst_code' =>'22',],
    ['name' => 'Jharkhand', 'gst_code' =>'20',],
    ['name' => 'Meghalaya', 'gst_code' =>'17',],
    ['name' => 'Mizoram','gst_code' =>'15',],
    ['name' => 'Nagaland','gst_code' =>'13',],
    ['name' => 'Odisha','gst_code' =>'21',],
    ['name' => 'Sikkim','gst_code' =>'11',],
    ['name' => 'Tripura','gst_code' =>'16',],
    ['name' => 'West Bengal','gst_code' =>'19',],
    ['name' => 'Chandigarh','gst_code' =>'04',],
    ['name' => 'Delhi','gst_code' =>'07',],
    ['name' => 'Haryana','gst_code' =>'06',],
    ['name' => 'Himachal Pradesh','gst_code' =>'02',],
    ['name' => 'Jammu & Kashmir','gst_code' =>'01',],
    ['name' => 'Punjab','gst_code' =>'03',],
    ['name' => 'Rajasthan','gst_code' =>'08',],
    ['name' => 'Uttar Pradesh','gst_code' =>'09',],
    ['name' => 'Uttarakhand','gst_code' =>'05',],
    ['name' => 'Andhra Pradesh','gst_code' =>'37',],
    ['name' => 'Karnataka','gst_code' =>'29',],
    ['name' => 'Kerala','gst_code' =>'32',],
    ['name' => 'Puducherry','gst_code' =>'34',],
    ['name' => 'Tamil Nadu','gst_code' =>'33',],
    ['name' => 'Goa','gst_code' =>'30',],
    ['name' => 'Gujarat','gst_code' =>'24',],
    ['name' => 'Madhya Pradesh','gst_code' =>'23',],
    ['name' => 'Maharashtra','gst_code' =>'27',],
    ['name' => 'Manipur','gst_code' =>'14',],
    ['name' => 'Daman and Diu','gst_code' =>'25',],
    ['name' => 'Dadra - Nagar Haveli','gst_code' =>'26',],
    ['name' => 'Telangana','gst_code' =>'36',]
];


        DB::table('states')->truncate();
        
        foreach($states as $state) {
            State::create($state);
        } 
    }
}
