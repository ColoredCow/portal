<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;

class ReceiveDailyEffortSummaryUserMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('email', 'LIKE', '%@coloredcow.in')->get();

        foreach ($users as $user) {
            $user->meta()->updateOrCreate(
                ['meta_key' => 'receive_daily_effort_summary'],
                ['meta_value' => 'yes']
            );
        }
    }
}
