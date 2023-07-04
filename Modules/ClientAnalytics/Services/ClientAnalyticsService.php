<?php

namespace Modules\ClientAnalytics\Services;

use Modules\Client\Entities\Client;;
use Modules\ClientAnalytics\Contracts\ClientAnalyticsServicesContract;

class ClientAnalyticsService implements ClientAnalyticsServicesContract
{
    public function getAllClients()
    {
        $clients = Client::all();
    
        
        return $clients;
    }
}
