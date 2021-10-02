<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HrApplicationRoundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        \DB::table('hr_application_round')->insert([
            'hr_application_id' => '1001',
            'hr_round_id' => '12',
            'trial_round_id' => '30',
            'calendar_event' => 'Created',
            'calendar_meeting_id' => '3404192777',
            'scheduled_date' => '2021-09-28 12:42:10',
            'scheduled_end' => '2021-09-28 01:15:10',
            'scheduled_person_id' => '3',
            'conducted_date' => '2021-09-28 12:42:10',
            'conducted_person_id' => '3',
            'round_status' => 'Resume Screening',
            'is_latest' => '1',
            'is_latest_trial_round' => '1',
            'mail_sent' => '1',
            'mail_subject' => 'Resume Shortlisting in Process',
            'mail_body' => 'Thank You for applying, Resume Shortlisting is in process. Please wait for further intimation! Good Luck!!',
            'mail_sender' => '1',
            'mail_sent_at' => '2021-09-26 12:47:10'
        ]);
    }
}
