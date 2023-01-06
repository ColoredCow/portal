<?php

namespace Modules\Invoice\Policies;

use Modules\User\Entities\User;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

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
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Invoice\Entities\Invoice  $invoice
     * @return mixed
     */
    public function view(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('finance_invoices.view');
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('finance_invoices.create');
    }

    /**
     * Determine whether the user can update the invoice.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Invoice\Entities\Invoice  $invoice
     * @return mixed
     */
    public function update(User $user, Invoice $invoice)
    {
        return $user->hasPermissionTo('finance_invoices.update');
    }

    /**
     * Determine whether the user can delete the invoice.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Invoice\Entities\Invoice  $invoice
     * @return mixed
     */
    public function delete(User $user, Invoice $invoice)
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
