<?php

namespace App\Services;

use App\Models\ClientCrmDetails;
use Modules\Client\Entities\Client;
use Modules\Prospect\Entities\Prospect;

class CrmServices
{
    public function getListData()
    {
        return [
            'clients'     => Client::all(),
            'prospectes'  => Prospect::all(),
            'crm_details' => ClientCrmDetails::all(),
        ];
    }
}
