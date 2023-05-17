<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Database\Factories\ClientBillingDetailsFactory;


class ClientBillingDetail extends Model
{
    use HasFactory;
    /** This should be people but we doing this for consistency  */
    protected $fillable = ['client_id', 'service_rates', 'service_rate_term', 'discount_rate', 'discount_rate_term', 'billing_frequency', 'bank_charges', 'currency', 'billing_date'];
    protected static function newFactory()
    {
        return new ClientBillingDetailsFactory();
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
