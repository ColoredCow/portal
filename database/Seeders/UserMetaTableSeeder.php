<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMetaTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_meta')->updateorInsert(
            ['user_id' => 1],
            ['max_appointments_per_day' => 2] 
        );
    }
}
