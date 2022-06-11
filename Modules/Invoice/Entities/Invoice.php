<?php

namespace Modules\Invoice\Entities;

use App\Traits\Encryptable;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use Encryptable;

    protected $fillable = ['client_id', 'project_id', 'status', 'currency', 'amount', 'sent_on', 'due_on', 'receivable_date', 'gst', 'file_path', 'comments', 'amount_paid', 'bank_charges', 'conversion_rate_diff', 'conversion_rate', 'tds', 'tds_percentage', 'currency_transaction_charge', 'payment_at', 'invoice_number'];

    protected $dates = ['sent_on', 'due_on', 'receivable_date', 'payment_at'];

    protected $encryptable = [
        'amount', 'gst', 'amount_paid', 'bank_charges', 'conversion_rate_diff', 'tds'
    ];

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeYear($query, $year)
    {
        return $query->whereYear('sent_on', $year);
    }

    public function scopeMonth($query, $month)
    {
        return $query->whereMonth('sent_on', $month);
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

    public function isAmountInINR()
    {
        return $this->currency == 'INR';
    }

    public function invoiceAmount()
    {
        $country = optional($this->client)->country;
        $amount = (int) $this->amount;

        if ($this->client->type == 'indian') {
            $amount = (int) $this->amount + (int) $this->gst;
        }

        return trim(optional($country)->currency_symbol . ' ' . $amount);
    }

    public function invoiceAmounts()
    {
        $country = optional($this->client)->country;
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

        if ($this->status == 'disputed' && $this->receivable_date->isPast()) {
            return false;
        }

        if ($this->receivable_date->isPast()) {
            return true;
        }

        return false;
    }
}
