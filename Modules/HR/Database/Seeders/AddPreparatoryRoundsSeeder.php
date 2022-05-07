<?php

namespace Modules\HR\Database\Seeders;

use Modules\HR\Entities\Round;
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
        Round::updateOrCreate([
            'name' => 'Preparatory-1'
        ], [
            'guidelines' => null,
            'reminder_enabled' => 0,
            'confirmed_mail_template' => null,
            'rejected_mail_template' => null,
            'in_trial_round' => 1,
        ]);
        Round::updateOrCreate([
            'name' => 'Preparatory-2'
        ], [
            'guidelines' => null,
            'reminder_enabled' => 0,
            'confirmed_mail_template' => null,
            'rejected_mail_template' => null,
            'in_trial_round' => 1,
        ]);
        Round::updateOrCreate([
            'name' => 'Preparatory-3'
        ], [
            'guidelines' => null,
            'reminder_enabled' => 0,
            'confirmed_mail_template' => null,
            'rejected_mail_template' => null,
            'in_trial_round' => 1,
        ]);
        Round::updateOrCreate([
            'name' => 'Preparatory-4'
        ], [
            'guidelines' => null,
            'reminder_enabled' => 0,
            'confirmed_mail_template' => null,
            'rejected_mail_template' => null,
            'in_trial_round' => 1,
        ]);
        Round::updateOrCreate([
            'name' => 'Warmup'
        ], [
            'guidelines' => null,
            'reminder_enabled' => 0,
            'confirmed_mail_template' => null,
            'rejected_mail_template' => null,
            'in_trial_round' => 1,
        ]);
    }
}
