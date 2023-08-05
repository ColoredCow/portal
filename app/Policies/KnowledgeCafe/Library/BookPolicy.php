<?php

namespace App\Policies\KnowledgeCafe\Library;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the book.
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('library_books.view');
    }

    /**
     * Determine whether the user can create books.
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('library_books.create');
    }

    /**
     * Determine whether the user can update the book.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('library_books.update');
    }

    /**
     * Determine whether the user can delete the book.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('library_books.delete');
    }

    /**
     * Determine whether the user can list books.
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('library_books.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('library_books.view');
    }
}
