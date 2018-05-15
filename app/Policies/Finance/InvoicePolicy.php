<?php

namespace App\Policies\Finance;

use App\User;
use App\Models\Finance\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return mixed
     */
    public function view(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.create');
    }

    /**
     * Determine whether the user can update the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return mixed
     */
    public function update(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('finance_invoices.update');
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return mixed
     */
    public function delete(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('finance_invoices.delete');
    }

    /**
     * Determine whether the user can list invoices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }
}
