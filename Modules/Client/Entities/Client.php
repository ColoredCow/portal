<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Database\Factories\ClientFactory;
use Modules\Client\Entities\Traits\HasHierarchy;
use Modules\Client\Entities\Scopes\ClientGlobalScope;

class Client extends Model
{
    use HasHierarchy, HasFactory;

    protected $fillable = ['name', 'email', 'key_account_manager_id', 'status', 'country', 'state', 'phone', 'phone', 'address', 'pincode', 'is_channel_partner', 'has_departments', 'channel_partner_id', 'parent_organisation_id'];

    protected $appends = ['type', 'currency'];

    protected static function booted()
    {
        static::addGlobalScope(new ClientGlobalScope);
    }

    protected static function newFactory()
    {
        return new ClientFactory();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function keyAccountManager()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getReferenceIdAttribute()
    {
        return sprintf('%03s', $this->id);
    }

    public function contactPersons()
    {
        return $this->hasMany(ClientContactPerson::class);
    }

    public function addresses()
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function billingDetails()
    {
        return $this->hasOne(ClientBillingDetail::class)->withDefault();
    }

    public function getTypeAttribute()
    {
        $address = $this->addresses->first();
        if (! $address) {
            return;
        }

        return  $address->country_id == '1' ? 'indian' : 'international';
    }

    public function getCountryAttribute()
    {
        return optional($this->addresses->first())->country;
    }

    public function getCurrencyAttribute()
    {
        return $this->type == 'indian' ? 'INR' : 'USD';
    }
}
