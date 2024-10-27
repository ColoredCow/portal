<?php

namespace Modules\Invoice\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Invoice\Entities\Invoice;
use Modules\User\Entities\User;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

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

    public function taxReport(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    public function taxReportExport(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    public function yearlyInvoiceReport(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    public function yearlyInvoiceReportExport(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    public function invoiceDetails(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    public function monthlyGstTaxReportExport(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }
}
