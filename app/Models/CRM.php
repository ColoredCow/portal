<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;
use Modules\Prospect\Entities\Prospect;

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
