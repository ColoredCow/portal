<?php

namespace App\Policies\Finance;

use App\User;
use App\Finance\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;


    public function before(User $user, Invoice $invoice)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Finance\Invoice  $invoice
     * @return mixed
     */
    public function view(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('view.finance_invoices');
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create.finance_invoices');
    }

    /**
     * Determine whether the user can update the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Finance\Invoice  $invoice
     * @return mixed
     */
    public function update(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('update.finance_invoices');
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Finance\Invoice  $invoice
     * @return mixed
     */
    public function delete(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('delete.finance_invoices');
    }
}
