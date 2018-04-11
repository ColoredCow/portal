<?php

namespace App\Models\Finance;

use App\Models\ProjectStageBilling;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'finance_invoices';

    protected $fillable = ['project_invoice_id', 'review_value', 'status', 'sent_on', 'sent_amount', 'currency_sent_amount', 'paid_on', 'paid_amount', 'payment_type', 'currency_paid_amount', 'comments', 'file_path', 'tds', 'currency_tds'];

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
    	return self::with([ 'projects' => function($query) {
	            $query->select('id', 'name');
	        }])
            ->orderBy('sent_on', 'desc')
            ->get();
    }
}
