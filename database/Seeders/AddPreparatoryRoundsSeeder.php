<?php
namespace Database\Seeders;

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
        \DB::table('hr_rounds')->insert(array (
            0 => 
            array (
                'name' => 'Preparatory-1',
                'guidelines' => NULL,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => NULL,
                'rejected_mail_template' => NULL,
                'in_trial_round' => 1,
            ),
            1 => 
            array (
                'name' => 'Preparatory-2',
                'guidelines' => NULL,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => NULL,
                'rejected_mail_template' => NULL,
                'in_trial_round' => 1,
            ),
            2 => 
            array (
                'name' => 'Preparatory-3',
                'guidelines' => NULL,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => NULL,
                'rejected_mail_template' => NULL,
                'in_trial_round' => 1,
            ),
            3 => 
            array (
                'name' => 'Preparatory-4',
                'guidelines' => NULL,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => NULL,
                'rejected_mail_template' => NULL,
                'in_trial_round' => 1,
            ),
            4 => 
            array (
                'name' => 'Warmup',
                'guidelines' => NULL,
                'reminder_enabled' => 0,
                'confirmed_mail_template' => NULL,
                'rejected_mail_template' => NULL,
                'in_trial_round' => 1,
            ),
        ));
    }
}

