<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id'];

    protected $table = 'hr_applications';
}
