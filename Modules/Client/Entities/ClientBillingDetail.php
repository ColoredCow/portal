<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Client\Database\Factories\ClientBillingDetailsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientBillingDetail extends Model
{
    /** This should be people but we doing this for consistency  */
    protected $fillable = ['client_id', 'service_rates', 'service_rate_term', 'discount_rate', 'discount_rate_term', 'billing_frequency', 'bank_charges', 'currency', 'billing_date'];

    use HasFactory;

    protected static function newFactory()
    {
        return new ClientBillingDetailsFactory();
    }
}
