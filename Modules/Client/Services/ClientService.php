<?php

namespace Modules\Client\Services;

use Modules\User\Entities\User;
use Modules\Client\Entities\Client;
use Modules\Client\Contracts\ClientServiceContract;

class ClientService implements ClientServiceContract
{
    public function index()
    {
        return  Client::with(['keyAccountManager', 'channelPartner', 'parentOrganisation'])->where('status', request()->input('status', 'active'))
            ->get();
    }

    public function getKeyAccountManagers()
    {
        return User::all();
    }

    public function store($data)
    {
        $data['status'] = $data['status'] ?? 'active';
        return Client::create($data);
    }

    public function updateClientData($data, $client)
    {
        if ($data['section'] == 'client-details') {
            return $this->updateClientDetails($data, $client);
        }

        if ($data['section'] == 'client-type') {
            return $this->updateClientTypeDetails($data, $client);
        }

        return $client->update($data);
    }

    private function updateClientDetails($data, $client)
    {
        return $client->update($data);
    }

    private function updateClientTypeDetails($data, $client)
    {
        $data['is_channel_partner'] = $data['is_channel_partner'] ?? false;
        $data['has_departments'] = $data['has_departments'] ?? false;
        return $client->update($data);
    }

    public function getChannelPartners()
    {
        return Client::where('is_channel_partner', true)->get();
    }

    public function getParentOrganisations()
    {
        return Client::where('has_departments', true)->get();
    }
}
