<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientBillingDetail extends Model
{
    /** This should be people but we doing this for consistency  */
    protected $fillable = ['client_id', 'service_rates', 'service_rate_term', 'discount_rate', 'discount_rate_term', 'billing_frequency', 'bank_charges', 'currency', 'billing_date'];
}
