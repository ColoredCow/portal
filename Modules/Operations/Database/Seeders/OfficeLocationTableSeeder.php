<?php

namespace Modules\Operations\Database\Seeders;

use Faker\Factory as faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Employee;
use Modules\Operations\Entities\OfficeLocation;
class OfficeLocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        OfficeLocation::updateOrCreate([

        'center_head'=>Employee::inRandomOrder()->first()->id,
        'location'=>$this->isgetlocationNames()[array_rand($this->isgetlocationNames())],
        'capacity'=>$faker->unique()->randomDigit,

        ]);
    }
    
    private function isgetlocationNames()
    {
        return [
        'gurugram',
        'Ranchi',
        'Tehri Garhwal',
        ];
    }
}
