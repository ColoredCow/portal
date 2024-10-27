<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['module', 'setting_key', 'setting_value'];

    public static function getNoShowEmail()
    {
        return [
            'subject' => self::where('setting_key', 'no_show_mail_subject')->first()->setting_value ?? null,
            'body' => self::where('setting_key', 'no_show_mail_body')->first()->setting_value ?? null,
        ];
    }
    public static function getApplicationApprovedEmail()
    {
        return [
            'subject' => self::where('setting_key', 'approved_mail_subject')->first()->setting_value ?? null,
            'body' => self::where('setting_key', 'approved_mail_body')->first()->setting_value ?? null,
        ];
    }
    public static function getOfferLetterTemplate()
    {
        return [
            'body' => self::where('setting_key', 'offer_letter_template')->first()->setting_value ?? null,
        ];
    }

    public static function scopeKey($query, $key)
    {
        return $query->where('setting_key', $key);
    }

    public static function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public static function getSendInvoiceTemplate()
    {
        return [
            'body' => self::where('setting_key', 'send-invoice')->first()->setting_value ?? null,
        ];
    }
}
