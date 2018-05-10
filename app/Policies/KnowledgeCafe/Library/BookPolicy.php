<?php

namespace App\Policies\KnowledgeCafe\Library;

use App\User;
use App\Models\KnowledgeCafe\Library\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the book.
     *
     * @param  \App\User  $user
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return mixed
     */
    public function view(User $user, Book $book)
    {
        return $user->hasPermissionTo('view.library_books');
    }

    /**
     * Determine whether the user can create books.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create.library_books');
    }

    /**
     * Determine whether the user can update the book.
     *
     * @param  \App\User  $user
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return mixed
     */
    public function update(User $user, Book $book)
    {
        return $user->hasPermissionTo('update.library_books');
    }

    /**
     * Determine whether the user can delete the book.
     *
     * @param  \App\User  $user
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return mixed
     */
    public function delete(User $user, Book $book)
    {
        return $user->hasPermissionTo('delete.library_books');
    }
}
