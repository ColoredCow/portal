<?php
namespace Modules\Client\Policies;

use Modules\Client\Entities\Client;
use Modules\User\Entities\User;

class ClientPolicy
{
    public function before($user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return $user->can('clients.view');
    }

    public function create(User $user)
    {
        return $user->can('clients.view');
    }

    public function update(User $user, Client $client)
    {
        return $user->can('clients.update') || $user->id === $client->key_account_manager_id;
    }

    public function delete(User $user)
    {
        return $user->can('clients.delete');
    }
}
