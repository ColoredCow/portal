<?php

namespace Modules\HR\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\HR\Entities\HrChannel;

class HrChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hrChannel = HrChannel::updateOrCreate(['name'=>'LinkedIn']);
        $hrChannel = HrChannel::updateOrCreate(['name'=>'Indeed']);
        $hrChannel = HrChannel::updateOrCreate(['name'=>'Website']);
    }
}