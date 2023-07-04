<?php

namespace Modules\ClientAnalytics\Services;
use App\Models\Country;
use Modules\User\Entities\User;
use Modules\Client\Entities\Client;;
use Modules\Client\Entities\ClientContactPerson;
use Modules\ClientAnalytics\Contracts\ClientAnalyticsServicesContract;

class ClientAnalyticsService implements ClientAnalyticsServicesContract
{
    public function getAllClients(){
        $clients = Client::all();
        return $clients;
    }
}
