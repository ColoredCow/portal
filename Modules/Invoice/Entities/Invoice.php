<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Invoice\Contracts\CurrencyServiceContract;

class Invoice extends Model implements Auditable
{
    use Encryptable, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = ['client_id', 'project_id', 'status', 'billing_level', 'currency', 'amount', 'sent_on', 'due_on', 'receivable_date', 'gst', 'file_path', 'comments', 'amount_paid', 'bank_charges', 'conversion_rate_diff', 'conversion_rate', 'tds', 'tds_percentage', 'currency_transaction_charge', 'payment_at', 'invoice_number', 'reminder_mail_count', 'payment_confirmation_mail_sent', 'deleted_at'];

    protected $dates = ['sent_on', 'due_on', 'receivable_date', 'payment_at'];

    protected $encryptable = [
        'amount', 'gst', 'amount_paid', 'bank_charges', 'conversion_rate_diff', 'tds'
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

        return $query->whereBetween('sent_on', [($invoiceYear . '-' . config('invoice.financial-month-details.financial_year_start_month') . '-' . '01'), (($invoiceYear + 1) . '-' . config('invoice.financial-month-details.financial_year_end_month') . '-' . '31')]);
    }

    public function scopeSentBetween($query, $startDate, $endDate)
    {
        $query->whereDate('sent_on', '>=', $startDate);
        $query->whereDate('sent_on', '<=', $endDate);

        return $query;
    }

    public function scopeApplyFilters($query, $filters)
    {
        if ($year = Arr::get($filters, 'year', '')) {
            $query = $query->year($year);
        }

        if ($month = Arr::get($filters, 'month', '')) {
            $query = $query->month($month);
        }

        if ($status = Arr::get($filters, 'status', '')) {
            $query = $query->status($status);
        }

        if ($country = Arr::get($filters, 'country', '')) {
            $query = $query->country($country);
        }

        if ($country = Arr::get($filters, 'region', '')) {
            $query = $query->region($country);
        }

        if ($clientId = Arr::get($filters, 'client_id', '')) {
            $query = $query->client($clientId);
        }

        if ($invoiceYear = Arr::get($filters, 'invoiceYear', '')) {
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
        } else {
            return $this->amount * $this->conversion_rate;
        }
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

        if ($this->conversion_rate) {
            return $this->getTotalAmountAttribute() * $this->conversion_rate;
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
            $monthDifference = ($currentMonthNumber + 12) - $invoiceStartMonthNumber;
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
