<?php

namespace Modules\Salary\Entities;

use Illuminate\Database\Eloquent\Model;

class SalaryConfiguration extends Model
{
    protected $guarded = [];

    public static function formatAll()
    {
        return self::all()->keyBy('slug');
    }
}
