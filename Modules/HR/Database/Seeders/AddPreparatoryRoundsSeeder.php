<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;

class AddPreparatoryRoundsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('hr_rounds')->insert([
            0 => [
                'name' => 'Preparatory-1',
                'guidelines' => null,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => null,
                'rejected_mail_template' => null,
                'in_trial_round' => 1,
            ],
            1 => [
                'name' => 'Preparatory-2',
                'guidelines' => null,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => null,
                'rejected_mail_template' => null,
                'in_trial_round' => 1,
            ],
            2 => [
                'name' => 'Preparatory-3',
                'guidelines' => null,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => null,
                'rejected_mail_template' => null,
                'in_trial_round' => 1,
            ],
            3 => [
                'name' => 'Preparatory-4',
                'guidelines' => null,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => null,
                'rejected_mail_template' => null,
                'in_trial_round' => 1,
            ],
            4 => [
                'name' => 'Warmup',
                'guidelines' => null,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => null,
                'rejected_mail_template' => null,
                'in_trial_round' => 1,
            ],
        ]);
    }
}
