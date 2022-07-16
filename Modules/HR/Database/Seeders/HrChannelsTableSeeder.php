<?php

namespace Modules\HR\Database\Seeders;

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
        $hrChannels = ['LinkedIn', 'Indeed', 'Website'];
        foreach ($hrChannels as $channelName) {
            HrChannel::updateOrCreate(['name' => $channelName]);
        }
    }
}

