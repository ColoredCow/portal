<?php
namespace Modules\Client\Entities;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    /** This should be people but we doing this for consistency  */
    protected $fillable = ['client_id', 'country_id', 'state', 'address', 'area_code', 'city', 'type', 'gst_number', 'pan_number'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getCompleteAddressAttribute()
    {
        $address = $this->address;
        if ($this->city) {
            $address .= ', ' . $this->city;
        }
        if ($this->state) {
            $address .= ', ' . $this->state;
        }
        if ($this->country) {
            $address .= ', ' . $this->country->name;
        }
        if ($this->area_code) {
            $address .= ', (' . $this->area_code . ')';
        }

        return $address;
    }
}
