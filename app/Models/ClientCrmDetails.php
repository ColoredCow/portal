<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;
use Modules\Prospect\Entities\Prospect;

class ClientCrmDetails extends Model
{
    protected $table = 'client_crm_details';

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function prospect()
    {
        return $this->hasMany(Prospect::class);
    }
}
