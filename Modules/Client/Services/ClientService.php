<?php

namespace Modules\Client\Services;

use Modules\User\Entities\User;
use Modules\Client\Entities\Client;
use Modules\Client\Contracts\ClientServiceContract;

class ClientService implements ClientServiceContract
{
    public function index()
    {
        return  Client::where('status', request()->input('status', 'active'))
            ->get();
    }

    public function getKeyAccountManagers()
    {
        return User::all();
    }

    public function store($data)
    {
        return Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'key_account_manager_id' => $data['key_account_manager_id'],
            'status' => $data['status'] ?? 'active'
        ]);
    }

    public function updateClientData($data, $client)
    {
        return $client->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'key_account_manager_id' => $data['key_account_manager_id'],
            'status' => $data['status']
        ]);
    }
}
