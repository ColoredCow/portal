<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['module', 'setting_key', 'setting_value'];

    public static function getRoundNotConductedEmail()
    {
        return [
            'subject' => self::where('setting_key', 'round_not_conducted_mail_subject')->first()->setting_value ?? null,
            'body' => self::where('setting_key', 'round_not_conducted_mail_body')->first()->setting_value ?? null
        ];
    }
}
