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
        return $this->hasMany(ProjectStageBilling::class, 'finance_invoice_id');
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

    /**
     * Get invoices that were sent in the date range
     *
     * @param  string $startDate
     * @param  string $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function filterBySentDate($start, $end, $paginated = false)
    {
        $invoices = self::whereDate('sent_on', '>=', $start)
            ->whereDate('sent_on', '<=', $end)
            ->orderBy('sent_on', 'desc');

        return $paginated ? $invoices->paginate(config('constants.pagination_size')) : $invoices->get();
    }

    /**
     * Get invoices that were sent or paid in the date range
     * @param  string  $start
     * @param  string  $end
     * @param  boolean $paginated
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function filterByDates($start, $end, $paginated = false)
    {
        $invoices = self::where(function ($query) use ($start, $end) {
            $query->where('sent_on', '>=', $start)
                      ->where('sent_on', '<=', $end);
        })->orWhere(function ($query) use ($start, $end) {
            $query->where('paid_on', '>=', $start)
                      ->where('paid_on', '<=', $end);
        })->orderBy('sent_on', 'desc')
            ->orderBy('paid_on', 'desc');

        $invoices->with('projectStageBillings.projectStage.project.client');

        return $paginated ? $invoices->paginate(config('constants.pagination_size')) : $invoices->get();
    }

    /**
     * Accessor to get invoice's client. This is called automatically when retrieving an invoice instance.
     * @return \App\Models\Client
     */
    public function getClientAttribute()
    {
        return optional($this->projectStageBillings()->first()->projectStage->project)->client;
    }
}
