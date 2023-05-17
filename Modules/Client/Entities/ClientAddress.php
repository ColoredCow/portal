<?php

namespace Modules\Client\Entities;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Database\Factories\ClientAddressesFactory;

class ClientAddress extends Model
{
    use HasFactory;
    /** This should be people but we doing this for consistency  */
    protected $fillable = ['client_id', 'country_id', 'state', 'address', 'area_code', 'city', 'type', 'gst_number'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    protected static function newFactory()
    {
        return new ClientAddressesFactory();
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
