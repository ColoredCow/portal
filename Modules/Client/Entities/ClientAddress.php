<?php

namespace Modules\Client\Entities;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Database\Factories\ClientAddressesFactory;

class ClientAddress extends Model
{
    /** This should be people but we doing this for consistency  */
    protected $fillable = ['client_id', 'country_id', 'state', 'address', 'area_code', 'city', 'type', 'gst_number'];

    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    protected static function newFactory()
    {
        return new ClientAddressesFactory();
    }
}
