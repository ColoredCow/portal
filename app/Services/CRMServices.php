<?php

namespace App\Services;

use Modules\Client\Entities\Client;
use Modules\Prospect\Entities\Prospect;

class CRMServices
{
    public function getListData()
    {
        return[
            'clients' =>  Client::all(),
            'prospectes' => Prospect::all(),
        ];
    }
}
