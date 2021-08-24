<?php

namespace App\Models\Finance;

use App\Models\ProjectStageBilling;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    protected $table = 'invoices_old';

    protected $dates = [
        'sent_on',
        'due_on',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['project', 'client'];

    /**
     * Get the project_stage_billings associated with the invoice.
     */
    public function projectStageBillings()
    {
        return $this->hasMany(ProjectStageBilling::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get details to list invoices.
     */
    public static function getList()
    {
        return self::orderBy('sent_on', 'desc')
            ->paginate(config('constants.pagination_size'));
    }

    /**
     * Get invoices that were sent in the date range.
     *
     * @param  string $start
     * @param  string $end
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
     * Get invoices that were sent or paid in the date range.
     * @param  string  $start
     * @param  string  $end
     * @param  bool $paginated
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function filterByDates($start, $end, $paginated = false)
    {
        $invoices = self::where(function ($query) use ($start, $end) {
            $query->where('sent_on', '>=', $start)->where('sent_on', '<=', $end);
        })->orWhereHas('payments', function ($query) use ($start, $end) {
            $query->where('paid_at', '>=', $start)->where('paid_at', '<=', $end);
        })->with(['payments' => function ($query) use ($start, $end) {
            $query->where('paid_at', '>=', $start)->where('paid_at', '<=', $end);
        }])->orderBy('sent_on', 'desc');

        return $paginated ? $invoices->paginate(config('constants.pagination_size')) : $invoices->get();
    }

    /**
     * Accessor to get invoice's client. This is called automatically when retrieving an invoice instance.
     *
     * @return \App\Models\Client
     */
    public function getClientAttribute()
    {
        return optional($this->projectStageBillings()->first()->projectStage->project)->client;
    }

    /**
     * Accessor to get invoice's project. This is called automatically when retrieving an invoice instance.
     *
     * @return \App\Models\Project
     */
    public function getProjectAttribute()
    {
        return $this->projectStageBillings()->first()->projectStage->project;
    }

    public function scopeUnpaid($query)
    {
        return $query->doesntHave('payments');
    }

    public function getStatusAttribute()
    {
        return $this->payments->count() ? 'paid' : 'unpaid';
    }
}
