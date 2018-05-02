<?php

namespace App\Models\Finance;

use App\Models\ProjectStageBilling;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'finance_invoices';

    protected $guarded = [];

    /**
     * Get the project_stage_billings associated with the invoice.
     */
    public function projectStageBillings()
    {
        return $this->belongsToMany(ProjectStageBilling::class, 'project_stage_billing_invoices', 'finance_invoice_id');
    }

    /**
     * Get details to list invoices
     *
     * @return self
     */
    public static function getList()
    {
    	return self::orderBy('sent_on', 'desc')
            ->paginate(config('constants.pagination_size'));
    }
}
