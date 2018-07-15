<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'module' => 'hr', 
            'setting_key' => 'applicant_create_autoresponder_subject', 
            'setting_value' => 'smple',
        ]);

        Setting::create([
            'module' => 'hr', 
            'setting_key' => 'applicant_create_autoresponder_body', 
            'setting_value' => 'hello',
        ]);

    }
}
