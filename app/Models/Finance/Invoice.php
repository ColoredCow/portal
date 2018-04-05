<?php

namespace App\Models\Finance;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'finance_invoices';

    protected $fillable = ['project_id', 'project_invoice_id', 'review_value', 'status', 'sent_on', 'sent_amount', 'currency_sent_amount', 'paid_on', 'paid_amount', 'currency_paid_amount', 'comments', 'file_path'];

    /**
     * Get the projects associated with the invoice.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_finance_invoices', 'finance_invoice_id');
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
