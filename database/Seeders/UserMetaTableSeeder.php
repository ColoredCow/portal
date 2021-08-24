<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_meta')->insert([
            [
                'id' => 1,
                'max_appointments_per_day' => 2,
            ]
        ]);
    }
}
