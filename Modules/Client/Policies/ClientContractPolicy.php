<?php

namespace Modules\Client\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Client\Entities\ClientContract;
use Modules\User\Entities\User;

class ClientContractPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ClientContract $contract)
    {
        if (! $user->hasPermissionTo('clients.view')) {
            return false;
        }

        $client = $contract->client;
        if (! $client) {
            return false;
        }

        if ($client->key_account_manager_id === $user->id) {
            return true;
        }

        return $client->projects()
            ->whereHas('teamMembers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->exists();
    }
}
