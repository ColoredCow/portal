<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Modules\Client\Entities\Client;
use Modules\Invoice\Contracts\CurrencyServiceContract;
use Modules\Project\Entities\Project;
use OwenIt\Auditing\Contracts\Auditable;

class Invoice extends Model implements Auditable
{
    use Encryptable, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = ['client_id', 'project_id', 'status', 'billing_level', 'currency', 'amount', 'sent_on', 'due_on', 'receivable_date', 'gst', 'file_path', 'comments', 'amount_paid', 'bank_charges', 'conversion_rate_diff', 'conversion_rate', 'tds', 'tds_percentage', 'currency_transaction_charge', 'payment_at', 'invoice_number', 'reminder_mail_count', 'payment_confirmation_mail_sent', 'deleted_at', 'term_start_date', 'term_end_date', 'sent_conversion_rate'];

    protected $dates = ['sent_on', 'due_on', 'receivable_date', 'payment_at', 'term_start_date', 'term_end_date'];

    protected $encryptable = [
        'amount', 'gst', 'amount_paid', 'bank_charges', 'conversion_rate_diff', 'tds', 'sent_conversion_rate',
    ];

    public function scopeStatus($query, $status)
    {
        if (is_string($status)) {
            return $query->where($this->getTable() . '.status', $status);
        }

        if (is_array($status)) {
            return $query->whereIn($this->getTable() . '.status', $status);
        }

        return $query;
    }

    public function scopeYear($query, $year)
    {
        return $query->whereYear($this->getTable() . '.sent_on', $year);
    }

    public function scopeMonth($query, $month)
    {
        return $query->whereMonth($this->getTable() . '.sent_on', $month);
    }

    public function scopeCountry($query, $country)
    {
        return $query
            ->whereHas('client.addresses.country', function ($subQuery) use ($country) {
                $subQuery->where('name', 'LIKE', "%{$country}%");
            });
    }

    public function scopeRegion($query, $region)
    {
        return $query
            ->whereHas('client.addresses.country', function ($subQuery) use ($region) {
                $operator = $region == 'indian' ? 'LIKE' : 'NOT LIKE';

                return $subQuery->where('name', $operator, '%India%');
            });
    }

    public function scopeClient($query, $clientId)
    {
        return $query->where($this->getTable() . '.client_id', $clientId);
    }

    public function scopeInvoiceInaYear($query, $invoiceYear)
    {
        if (! is_numeric($invoiceYear)) {
            return $query;
        }

        $FYStartMonth = config('invoice.financial-month-details.financial_year_start_month');
        $FYEndMonth = config('invoice.financial-month-details.financial_year_end_month');

        $startDate = "{$invoiceYear}-{$FYStartMonth}-01";
        $endDate = ($invoiceYear + 1) . "-{$FYEndMonth}-31";

        return $query->whereBetween('sent_on', [$startDate, $endDate]);
    }

    public function scopeSentBetween($query, $startDate, $endDate)
    {
        $query->whereDate('sent_on', '>=', $startDate);
        $query->whereDate('sent_on', '<=', $endDate);

        return $query;
    }

    public function scopeApplyFilters($query, $filters)
    {
        $year = Arr::get($filters, 'year', '');
        $month = Arr::get($filters, 'month', '');
        $status = Arr::get($filters, 'status', '');
        $country = Arr::get($filters, 'country', '');
        $region = Arr::get($filters, 'region', '');
        $clientId = Arr::get($filters, 'client_id', '');
        $invoiceYear = Arr::get($filters, 'invoiceYear', '');

        if ($year) {
            $query = $query->year($year);
        }

        if ($month) {
            $query = $query->month($month);
        }

        if ($status) {
            $query = $query->status($status);
        }

        if ($country) {
            $query = $query->country($country);
        }

        if ($region) {
            $query = $query->region($region);
        }

        if ($clientId) {
            $query = $query->client($clientId);
        }

        if ($invoiceYear) {
            $query = $query->InvoiceInaYear($invoiceYear);
        }

        return $query;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getDisplayAmountAttribute()
    {
        $country = optional($this->client)->country;

        return $this->amount . ' ' . optional($country)->currency_symbol;
    }

    public function getFormattedInvoiceNumberAttribute()
    {
        return substr($this->invoice_number, 0, -4);
    }

    public function isAmountInINR()
    {
        return $this->currency == 'INR';
    }

    public function invoiceAmount()
    {
        $country = optional($this->client)->country;
        $amount = (float) $this->amount;

        if ($this->client->type == 'indian') {
            $amount = (float) $this->amount + (float) $this->gst;
        }

        return trim(optional($country)->currency_symbol . $amount);
    }

    public function invoiceAmountDifference()
    {
        $amountDifference = 0;
        $lastInvoiceEndDate = $this->sent_on->subMonth()->endOfMonth();
        $amount = (float) $this->amount;
        if ($this->client->type == 'indian') {
            $amount += (float) $this->gst;
        }
        $currentMonthAmount = $amount;
        $lastMonthAmountDetail = self::where('sent_on', '<', $lastInvoiceEndDate)
            ->where('client_id', $this->client_id)->where('project_id', $this->project_id)
            ->orderBy('sent_on', 'DESC')
            ->first();
        $lastMonthAmount = $lastMonthAmountDetail ? (float) $lastMonthAmountDetail->amount : 0;
        if ($this->client->type == 'indian') {
            $lastMonthAmount = $lastMonthAmountDetail ? (float) $lastMonthAmountDetail->amount + (float) $lastMonthAmountDetail->gst : 0;
        }
        $amountDifference = $currentMonthAmount - $lastMonthAmount;
        if ($lastMonthAmount != 0) {
            $percentage = number_format($amountDifference / $lastMonthAmount * 100, 2);

            return "{$amountDifference} ({$percentage}%)";
        }

        return $amountDifference;
    }

    public function invoiceAmounts()
    {
        $amount = (int) $this->amount;

        if ($this->client->type == 'indian') {
            $amount = (int) $this->amount + (int) $this->gst;
        }

        return $amount;
    }

    public function shouldHighlighted()
    {
        if ($this->status == 'paid') {
            return false;
        }
        if ($this->status == 'disputed') {
            return false;
        }

        if ($this->receivable_date < date('Y-m-d')) {
            return true;
        }

        return false;
    }
    public function getInvoiceAmountInInrAttribute()
    {
        if (optional($this->currency) == config('constants.countries.india.currency')) {
            return $this->amount;
        }

        return $this->amount * $this->conversion_rate;
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->gst;
    }

    public function getTotalAmountInInrAttribute()
    {
        if ($this->currency == config('constants.countries.india.currency')) {
            return $this->getTotalAmountAttribute();
        }

        if ($this->sent_conversion_rate) {
            return $this->getTotalAmountAttribute() * (int)($this->sent_conversion_rate);
        }

        return $this->getTotalAmountAttribute() * app(CurrencyServiceContract::class)->getCurrentRatesInINR();
    }

    public function getTermAttribute()
    {
        if (optional($this->client->billingDetails)->billing_date == 1) {
            return $this->sent_on->subMonth()->format('F');
        }

        $invoiceStartMonthNumber = $this->sent_on->subMonth()->month;
        $currentMonthNumber = today(config('constants.timezone.indian'))->month;
        if (optional($this->client->billingDetails)->billing_date > today()->day) {
            $currentMonthNumber -= 1;
        }
        $monthDifference = $currentMonthNumber - $invoiceStartMonthNumber;
        if ($monthDifference < 0) {
            $monthDifference = $currentMonthNumber + 12 - $invoiceStartMonthNumber;
        }
        $termStartDate = $this->client->getMonthStartDateAttribute($monthDifference);
        $termEndDate = $this->client->getMonthEndDateAttribute($monthDifference);
        $term = $termStartDate->format('M') . ' - ' . $termEndDate->format('M');

        if ($termStartDate->format('M') == $termEndDate->format('M')) {
            $term = $termEndDate->format('F');
        }

        return $term;
    }
}
