<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentConfiguration extends Model
{
    protected $guarded = [];

    public static function formatAll()
    {
        return self::all()->keyBy('slug');
    }
}
