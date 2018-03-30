<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    $fillable = ['name', 'email', 'phone', 'address'];
}
