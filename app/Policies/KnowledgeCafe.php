<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KnowledgeCafe
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function view(User $user)
    {
        return $user->hasAnyPermission(['weeklydoses.view', 'library_books.view']);
    }
}
