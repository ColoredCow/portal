<?php
namespace App\Policies\Finance;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the invoice.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.create');
    }

    /**
     * Determine whether the user can update the invoice.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.update');
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.delete');
    }

    /**
     * Determine whether the user can list invoices.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }
}
