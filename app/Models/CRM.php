<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CRM extends Model
{
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function prospect()
    {
        return $this->hasMany(Prospect::class);
    }
}
